<template>
  <div class="mt-5">
    <div class="col-md-6 mx-auto">
      <h2 class="text-left mb-3">{{ isEditing ? 'Edit Company' : 'Add Company' }}</h2>
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="saveCompany" class="form-group">
            <div class="form-group mb-3">
              <label for="company_name">Company Name</label>
              <input
                v-model="company_name"
                type="text"
                class="form-control"
                id="company_name"
                placeholder="Company Name"
                required
              />
            </div>
            <div class="form-group mb-3">
              <label for="company_email">Company Email</label>
              <input
                v-model="company_email"
                type="email"
                class="form-control"
                id="company_email"
                placeholder="Company Email"
                required
              />
            </div>
            <div class="form-group mb-3">
              <label for="country_id">Country</label>
              <select
                v-model="country_id"
                class="form-control"
                id="country_id"
                required
              >
                <option disabled value="">Choose...</option>
                <option
                  v-for="country in countries"
                  :key="country.id"
                  :value="country.id"
                >
                  {{ country.name }}
                </option>
              </select>
            </div>
            <center>
              <button type="submit" class="btn btn-primary">{{ isEditing ? 'Update' : 'Add' }}</button>
            </center>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from '../api';

export default {
  props: {
    company: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      company_name: this.company.company_name || '',
      company_email: this.company.company_email || '',
      country_id: this.company.country_id || '',
      countries: [],
    };
  },
  computed: {
    isEditing() {
      return !!this.company.id;
    },
  },
  created() {
    // Fetch countries list to populate the dropdown
    apiClient.get('/countries').then(response => {
      this.countries = response.data;
    });
  },
  methods: {
    async saveCompany() {
      try {
        if (this.isEditing) {
          await apiClient.put(`/companies/${this.company.id}`, {
            company_name: this.company_name,
            company_email: this.company_email,
            country_id: this.country_id,
          });
        } else {
          await apiClient.post('/companies', {
            company_name: this.company_name,
            company_email: this.company_email,
            country_id: this.country_id,
          });
        }
        this.$emit('saved');
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>

<style>
body {
  background-color: #f8f9fa;
}

h2 {
  margin-bottom: 20px;
}

.form-group label {
  font-weight: bold;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #004085;
}

.alert {
  margin-top: 20px;
}
</style>

