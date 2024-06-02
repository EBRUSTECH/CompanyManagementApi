<!-- <template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <input v-model="full_name" placeholder="Full Name" required />
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="mobile" placeholder="Mobile" required />
      <input v-model="address" placeholder="Address" required />
      <input v-model="country_id" placeholder="Country ID" required />
      <input v-model="password" type="password" placeholder="Password" required />
      <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required />
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import apiClient from '../api';

export default {
  data() {
    return {
      full_name: '',
      email: '',
      mobile: '',
      address: '',
      country_id: '',
      password: '',
      password_confirmation: '',
    };
  },
  methods: {
    async register() {
      try {
        const response = await apiClient.post('/register', {
          full_name: this.full_name,
          email: this.email,
          mobile: this.mobile,
          address: this.address,
          country_id: this.country_id,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });
        localStorage.setItem('token', response.data.token);
        this.$router.push('/dashboard');
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script> -->

<template>
  <div class="container mt-5">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="fullName">Full Name</label>
          <input type="text" class="form-control" id="fullName" v-model="full_name" placeholder="Full Name" required />
        </div>
        <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" v-model="email" placeholder="Email" required />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" v-model="password" placeholder="Password" required />
        </div>
        <div class="form-group col-md-6">
          <label for="passwordConfirmation">Confirm Password</label>
          <input type="password" class="form-control" id="passwordConfirmation" v-model="password_confirmation" placeholder="Confirm Password" required />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="mobile">Mobile</label>
          <input type="text" class="form-control" id="mobile" v-model="mobile" placeholder="Mobile" required />
        </div>
        <div class="form-group col-md-6">
          <label for="country">Country</label>
          <select id="country" class="form-control" v-model="country_id" required>
            <option disabled value="">Choose...</option>
            <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.name }}</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" v-model="address" placeholder="1234 Main St" required />
      </div>
      <div class="form-group">
        <label for="image">Profile Image</label>
        <input type="file" class="form-control-file" id="image" @change="onFileChange" required />
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
      <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      full_name: '',
      email: '',
      mobile: '',
      address: '',
      country_id: '',
      password: '',
      password_confirmation: '',
      image: '',
      countries: [],
      error: null,
    };
  },
  created() {
    axios.get('/api/countries').then(response => {
      this.countries = response.data;
    });
  },
  methods: {
    onFileChange(e) {
      this.image = e.target.files[0];
    },
    async register() {
      this.error = null;
      const formData = new FormData();
      formData.append('full_name', this.full_name);
      formData.append('email', this.email);
      formData.append('password', this.password);
      formData.append('password_confirmation', this.password_confirmation);
      formData.append('mobile', this.mobile);
      formData.append('address', this.address);
      formData.append('country_id', this.country_id);
      formData.append('image', this.image);

      try {
        const response = await axios.post('/api/register', formData);
        localStorage.setItem('token', response.data.token);
        this.$router.push('/dashboard');
      } catch (error) {
        if (error.response && error.response.data) {
          this.error = error.response.data.message;
        } else {
          this.error = 'An error occurred during registration.';
        }
      }
    }
  }
};
</script>

<style>
body {
  background-color: #f8f9fa;
}

.container {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

