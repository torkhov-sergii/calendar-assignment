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
  border: 1px solid #fff;
  padding: 20px;
  width: 360px;
  background: #fff;
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8), inset 0 0 30px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
}

.calendar-header {
  font-weight: bold;
}

.calendar-weekdays {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #eee;
  margin-bottom: 10px;

  div {
    flex: 1 1 0px;
    margin: 1px;

    text-align: left;
    padding: 5px 0;
  }
}

.calendar-days {}

.calendar-week {
  display: flex;
  justify-content: space-between;
}

@media (max-width: 768px) {
  .calendar {
    width: 100%;
  }
}
</style>
