<template>
  <div class="mt-5">
    <div class="col-md-6 mx-auto">
      <h1 class="text-center mb-4">Profile</h1>
      <div class="text-center mb-4">
        <img
          :src="profile.image_url"
          alt="Profile Image"
          class="rounded-circle"
          width="150"
          height="150"
        />
      </div>
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="updateProfile" class="form-group" enctype="multipart/form-data">
            <div class="form-group mb-3">
              <label for="full_name">Full Name</label>
              <input
                id="full_name"
                v-model="profile.full_name"
                type="text"
                class="form-control"
                required
              />
            </div>
            <div class="form-group mb-3">
              <label for="email">Email</label>
              <input
                id="email"
                v-model="profile.email"
                type="email"
                class="form-control"
                required
              />
            </div>
            <div class="form-group mb-3">
              <label for="mobile">Mobile</label>
              <input
                id="mobile"
                v-model="profile.mobile"
                type="text"
                class="form-control"
                required
              />
            </div>
            <div class="form-group mb-3">
              <label for="address">Address</label>
              <input
                id="address"
                v-model="profile.address"
                type="text"
                class="form-control"
                required
              />
            </div>
            <div class="form-group mb-3">
              <label for="country_id">Country</label>
              <select
                id="country_id"
                v-model="profile.country_id"
                class="form-control"
                required
              >
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
              <label for="image">Profile Image</label>
              <input
                id="image"
                type="file"
                class="form-control-file"
                @change="onImageChange"
              />
            </div>
            <center>
              <button type="submit" class="btn btn-primary">
                Update Profile
              </button>
            </center>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "../api";

export default {
  name: "UserProfile",
data() {
  return {
    profile: {
      full_name: "",
      email: "",
      mobile: "",
      address: "",
      country_id: "",
      image: null,
      image_url: "",
    },
    countries: [],
    selectedImage: null,
  };
},

  async created() {
    try {
      const userResponse = await apiClient.get("/user");
      this.profile = userResponse.data;
      if (this.profile.image) {
        this.profile.image_url = `http://localhost:8000/storage/images/${this.profile.image}`;
      }

      const countriesResponse = await apiClient.get("/countries");
      this.countries = countriesResponse.data;
    } catch (error) {
      console.error(error);
    }
  },
 methods: {
  onImageChange(event) {
    this.selectedImage = event.target.files[0];
    this.profile.image_url = URL.createObjectURL(this.selectedImage);
  },
  async updateProfile() {
    try {
      const formData = new FormData();
      formData.append("full_name", this.profile.full_name);
      formData.append("email", this.profile.email);
      formData.append("mobile", this.profile.mobile);
      formData.append("address", this.profile.address);
      formData.append("country_id", this.profile.country_id);
      if (this.selectedImage) {
        formData.append("image", this.selectedImage);
      }

      // Log formData to check if all fields are populated correctly
      for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
      }

      const response = await apiClient.put("/user", formData);
      this.profile = response.data.user;
      if (this.profile.image) {
        this.profile.image_url = `http://localhost:8000/storage/images/${this.profile.image}`;
      }
      alert("Profile updated successfully");
    } catch (error) {
      console.error("Error response:", error.response.data);
      console.error("Error message:", error.message);
      alert("Failed to update profile");
    }
  },
},

};
</script>

<style>
body {
  background-color: #f8f9fa;
}

h1 {
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

.rounded-circle {
  border-radius: 50%;
  object-fit: cover;
}
</style>
