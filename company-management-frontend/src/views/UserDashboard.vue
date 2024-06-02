<template>
  <div>
    <h1>Dashboard</h1>
    <CompanyList />
  </div>
</template>

<script>
import CompanyList from '../components/CompanyList.vue';

export default {
  components: {
    CompanyList,
  },
};
</script>
