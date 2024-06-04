<template>
  <div class="mt-5 mb-5">
    <div class="col-md-6 mx-auto">
      <h2 class="text-left mb-3">Register</h2>
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="register" class="form-group">
            <div class="form-group mb-3">
              <label for="fullName">Full Name</label>
              <input
                type="text"
                class="form-control"
                id="fullName"
                v-model="full_name"
                placeholder="Full Name"
                required
              />
            </div>

            <div class="form-group mb-3">
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                v-model="email"
                placeholder="Email"
                required
              />
            </div>

            <div class="form-group mb-3">
              <label for="password">Password</label>
              <input
                type="password"
                class="form-control"
                id="password"
                v-model="password"
                placeholder="Password"
                required
              />
            </div>

            <div class="form-group mb-3">
              <label for="passwordConfirmation">Confirm Password</label>
              <input
                type="password"
                class="form-control"
                id="passwordConfirmation"
                v-model="password_confirmation"
                placeholder="Confirm Password"
                required
              />
            </div>

            <div class="form-group mb-3">
              <label for="mobile">Mobile</label>
              <input
                type="text"
                class="form-control"
                id="mobile"
                v-model="mobile"
                placeholder="Mobile"
                required
              />
            </div>

            <div class="form-group mb-3">
              <label for="country">Country</label>
              <select
                id="country"
                class="form-control"
                v-model="country_id"
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

            <div class="form-group mb-3">
              <label for="address">Address</label>
              <input
                type="text"
                class="form-control"
                id="address"
                v-model="address"
                placeholder="1234 Main St"
                required
              />
            </div>

            <div class="form-group mb-3">
              <label for="image">Profile Image</label>
              <input
                type="file"
                class="form-control-file"
                id="image"
                @change="onFileChange"
              />
            </div>

            <center>
              <button type="submit" class="btn btn-primary">Register</button>
            </center>

            <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "../api";

export default {
  data() {
    return {
      full_name: "",
      email: "",
      mobile: "",
      address: "",
      country_id: "",
      password: "",
      password_confirmation: "",
      image: "",
      countries: [],
      error: null,
    };
  },
  created() {
    apiClient.get("/countries").then((response) => {
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
      formData.append("full_name", this.full_name);
      formData.append("email", this.email);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      formData.append("mobile", this.mobile);
      formData.append("address", this.address);
      formData.append("country_id", this.country_id);
      formData.append("image", this.image);

      try {
        const response = await apiClient.post("/register", formData);
        localStorage.setItem("token", response.data.token);
        this.$router.push("/dashboard");
      } catch (error) {
        if (error.response && error.response.data) {
          this.error = error.response.data.message;
        } else {
          this.error = "An error occurred during registration.";
        }
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
