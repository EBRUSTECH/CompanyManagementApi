<template>
  <div class="container mt-5">
    <h2 class="mb-4">Companies and Services</h2>
    <div class="row">
      <div class="col-md-4" v-for="company in companies" :key="company.id">
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">Company: {{ company.company_name }}</h5>
            <p class="card-text"><strong>Email: </strong>{{ company.company_email }}</p>
            <h6>Services:</h6>
            <ul>
              <li v-for="service in company.services" :key="service.id">{{ service.name }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from '../api';

export default {
  data() {
    return {
      companies: [],
    };
  },
  async created() {
    try {
      const response = await apiClient.get('/companies');
      this.companies = response.data;
    } catch (error) {
      console.error('Error fetching companies:', error);
    }
  },
};
</script>

<style>
.card {
  transition: transform 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}

.container {
  background-color: #f8f9fa;
  padding: 20px;
  border-radius: 10px;
}

h2 {
  color: #343a40;
}

.card-title {
  color: #007bff;
}
</style>
