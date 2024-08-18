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
  flex: 1 1 0px;
  margin: 0px;

  text-align: center;
  aspect-ratio: 1 / 1;
  display: flex;
  align-items: center;
  justify-content: center;

  &.marked {
    background: rgba(102, 204, 247, 0.8);
    border: none;
    color: #fff;
    box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.2);
  }

  &.hide {
    opacity: 0;
  }
}
</style>
