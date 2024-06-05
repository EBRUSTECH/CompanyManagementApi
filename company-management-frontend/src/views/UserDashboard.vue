<template>
  <div>
    <div class="container">
      <h3>Dashboard</h3>
    </div>
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
