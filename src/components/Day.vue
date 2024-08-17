<template>
  <div v-for="day in week" :key="day.date" :class="{ 'calendar-day': true, 'hide': !day.show, 'marked': day.marked }">
    <div v-show="day.show">{{ day.date }}</div>
  </div>
</template>

<script>
export default {
  props: ['week'],
}
</script>

<style scoped>
.calendar-day {
  margin: 2px;

  text-align: center;
  padding: 10px;
  border: 1px solid #ddd;

  &.marked {
    background: #f00;
  }

  &.hide {
    opacity: 0;
  }
}
</style>
