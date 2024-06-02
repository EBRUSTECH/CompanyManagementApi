<template>
  <div>
    <h1>Home</h1>
    <ul>
      <li v-for="company in companies" :key="company.id">
        {{ company.company_name }} - Services: {{ company.services.map(service => service.name).join(', ') }}
      </li>
    </ul>
  </div>
</template>

<script>
import apiClient from '../api';

export default {
  name: 'HomePage',
  data() {
    return {
      companies: [],
    };
  },
  async mounted() {
    try {
      const response = await apiClient.get('/public/companies');
      this.companies = response.data;
    } catch (error) {
      console.error(error);
    }
  },
};
</script>
