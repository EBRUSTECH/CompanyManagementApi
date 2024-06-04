<template>
  <div class="mt-5">
    <div class="col-md-6 mx-auto">
      <h2 class="text-left mb-3">Login</h2>
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="login" class="form-group">
            <div class="form-group mb-3">
              <label for="email">Email</label>
              <input
                v-model="email"
                type="email"
                class="form-control"
                id="email"
                placeholder="Email"
                required
              />
            </div>
            <div class="form-group mb-3">
              <label for="password">Password</label>
              <input
                v-model="password"
                type="password"
                class="form-control"
                id="password"
                placeholder="Password"
                required
              />
            </div>
            <center>
              <button type="submit" class="btn btn-primary">Login</button>
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
      email: "",
      password: "",
      error: null,
    };
  },
  methods: {
    async login() {
      try {
        const response = await apiClient.post("/login", {
          email: this.email,
          password: this.password,
          error: null,
        });
        localStorage.setItem("token", response.data.token);
        this.$router.push("/dashboard");
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
