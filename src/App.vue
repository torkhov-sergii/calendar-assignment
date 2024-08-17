<script setup>
import Day from './components/Day.vue';
import moment from 'moment';
import axios from 'axios';
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
        <Day :week="week"></Day>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      apiUrl: 'http://127.0.0.1:8000',
      predefinedMonth: 'August',
      predefinedYear: 2024,
      weekdays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      calendarData: [],
      markedDates: [],
    }
  },

  methods: {
    generateCalendar() {
      const currentMonth = this.date.clone().month();
      const nextMonth = this.date.clone().add(1, 'month').month();
      const weekdayOfFirstMonthDay = this.date.startOf('month').weekday();

      const calendarData = [];

      let day = this.date.clone().subtract(weekdayOfFirstMonthDay, 'days');

      while (day.month() < nextMonth) {
        const week = [];

        for (let weekDay = 0; weekDay < 7; weekDay++) {

          week.push({
            date: day.date(),
            show: day.month() == currentMonth,
            marked: this.markedDates.includes(day.date()),
          });

          day.add(1, 'day');

        }
        calendarData.push(week);
      }

      this.calendarData = calendarData;
    },
    async fetchMarkedDatesData() {
      try {
        const response = await axios.post(this.apiUrl, {
          year: this.predefinedYear,
          month: this.predefinedMonth,
        });

        const markedDays = response.data.map(date => {
          return parseInt(moment(date, 'YYYY-MM-DD').format('DD'));
        });

        this.markedDates = markedDays;

        this.generateCalendar();
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }
  },

  mounted() {
    this.generateCalendar();
    this.fetchMarkedDatesData();
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
</style>
