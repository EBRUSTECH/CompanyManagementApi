import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-Type": "multipart/form-data",
  },
});

apiClient.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default apiClient;
