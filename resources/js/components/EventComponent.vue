<template>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h1> Calendar </h1>
    </div>
    <div class="col-4   ">
      <form>
  <div class="form-row">
    <div class="form-group">
      <label for="eventName">Event</label>
      <input type="text" class="form-control" id="eventName" v-model="events.name">
    </div>
  </div>
  <div class="form-group">
    <label for="eventFrom">From</label>
    <input type="date" data-date-format="yyyy-mm-dd" class="form-control" id="eventFrom" v-model="events.from">
    <label for="eventTo">To</label>
    <input type="date" data-date-format="yyyy-mm-dd" class="form-control" id="eventTo" v-model="events.to">
  </div>
  <div class="form-group">
    <div v-for="weekday in weekdays" :key="weekdays.indexOf(weekday)">
      <input :id="weekday.id" :value="weekday.value" name="weekday" type="checkbox" v-model="checkedWeekdays">
      <label class="form-check-label mr-4" for="eventDay">
        {{weekday.value}}
      </label>
    </div>
  </div>
  <button type="button" class="btn btn-primary" v-on:click="display">Save</button>
</form>
    </div>
    <div class="col-8">
    <h2>{{date}}</h2>
<table class="table">
  <tbody v-for="day in days" :key="days.indexOf(day)" >
    <tr :class="checked(day) ? 'table-success' : ''">
      <td>{{day}}</td>
      <td>{{events.name}}</td>
    </tr>
  </tbody>
</table>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        data: () => ({
            //dateName: [],
            success: false,
            weekday: '',
            weekdays: [
                 { id: 0, value: 'Mon' },
                 { id: 1, value: 'Tue' },
                 { id: 2, value: 'Wed' },
                 { id: 3, value: 'Thu' },
                 { id: 4, value: 'Fri' },
                 { id: 5, value: 'Sat' },
                 { id: 6, value: 'Sun' },
            ],
            checkedWeekdays: [],
            date: '',
            days: [],
            events: {
                name: '',
                from: '',
                to: '',
            },
        }),
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
        checked(day){
            var substring = day.substring(3, 6);
            var find = this.checkedWeekdays.findIndex(element => element.includes(substring));
            if(find >= 0){
                return true;
            }else{
                return false;
            }
        },
         save () {

            // var bodyFormData = new FormData();
            // bodyFormData.append('name', this.events.name);
            // bodyFormData.append('from_date', this.events.from);
            // bodyFormData.append('to_date', this.events.to);
            // bodyFormData.append('event_date', this.checkedWeekdays);
            console.log(this.events.name);
             console.log(this.events.from);
              console.log(this.events.to);
               console.log(this.checkedWeekdays);
            axios({
                method: "post",
                url: "api/events",
                data: {
                    'name' : this.events.name,
                    'from_date' : this.events.from,
                    'to_date' : this.events.to,
                    'event_date' : this.checkedWeekdays.toString()
                },
            })
            .then(function (response) {
            //handle success
                console.log(response);
            })
            .catch(function (response) {
            //handle error
                console.log(response);
            });
            //console.log(this.checkedWeekdays)
         },
        display(){
                var getDates = function(startDate, endDate) {
                var dates = [],
                    currentDate = startDate,
                    addDays = function(days) {
                        var date = new Date(this.valueOf());
                        date.setDate(date.getDate() + days);
                        return date;
                    };
                while (currentDate <= endDate) {
                    dates.push(currentDate.toLocaleString('default', { day: '2-digit' }) + ' ' +
                    currentDate.toLocaleString('default', { weekday: 'short' }));
                    currentDate = addDays.call(currentDate, 1);
                    //this.dateName.push(currentDate.toLocaleString('default', { weekday: 'short' }));
                }
                return dates;
                };

                var from_date = new Date(this.events.from);
                this.date = from_date.toLocaleString('default', { month: 'short' }) + ' '
                        + from_date.toLocaleString('default', { year: 'numeric' });

                this.days = getDates(new Date(this.events.from), new Date(this.events.to));

                 console.log('name ' + this.events.name)
                 console.log('from ' + this.events.from)
                 //console.log('to ' + this.dateName)

                 this.save();

            }
        }
    }
</script>
