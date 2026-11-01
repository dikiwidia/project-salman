import axios from "axios";
import router from "../router";
import { useAuth } from "../store/auth";

const client = axios.create({
  baseURL: `${import.meta.env.VITE_API_URL ?? "http://localhost:8000"}/api`,
  headers: { Accept: "application/json" },
});

client.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
});

client.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      useAuth().clearSession();

      if (router.currentRoute.value.path !== "/login") {
        router.push("/login");
      }
    }

    return Promise.reject(error);
  },
);

export default client;
