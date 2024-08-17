<script setup>
</script>

<template>
  <div class="calendar">
    <div class="calendar-header">
      {{ predefinedMonth }} {{ predefinedYear }}
    </div>
    <div class="calendar-weekdays">
      <div v-for="day in weekdays" :key="day">{{ day }}</div>
    </div>
    <div class="calendar-days">
      <div v-for="week in calendarData" :key="week.index" class="calendar-week">
        <div v-for="day in week" :key="day.date" :class="{ 'calendar-day': true, 'marked': day.marked }">
          {{ day.date }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';

export default {
  data() {
    return {
      predefinedMonth: 'August',
      predefinedYear: 2024,
      weekdays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      calendarData: [],
      markedDates: [5, 10, 15], //TODO
    }
  },

  methods: {
    generateCalendar() {
      const currentMonth = this.date.clone().month();
      const nextMonth = this.date.clone().add(1, 'month').month();
      const weekdayOfFirstMonthDay = this.date.startOf('month').weekday();

      const calendarData = [];

      let day = this.date.clone().subtract(weekdayOfFirstMonthDay, 'days');

      console.log(this.markedDates);

      while (day.month() < nextMonth) {
        const week = [];

        for (let weekDay = 0; weekDay < 7; weekDay++) {

          week.push({
            date: day.date(),
            marked: this.markedDates.includes(day.date()),
          });

          day.add(1, 'day');

        }
        calendarData.push(week);
      }

      this.calendarData = calendarData;
    },
  },

  mounted() {
    this.generateCalendar();
  },

  computed: {
    date() {
      return moment(`${this.predefinedMonth} ${this.predefinedYear}`, 'MMMM YYYY');
    },
  },
}
</script>

<style>
.calendar {
  padding: 20px;
}

.calendar-header {}

.calendar-weekdays {
  display: flex;
  justify-content: space-between;
}

.calendar-days {}

.calendar-week {
  display: flex;
  justify-content: space-between;
}

.calendar-day {
  margin: 2px;

  text-align: center;
  padding: 10px;
  border: 1px solid #ddd;

  &.marked {
    background: #f00;
  }
}
</style>
