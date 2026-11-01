import { defineStore } from "pinia";
import client from "../api/client";

export const useAuth = defineStore("auth", {
  state: () => ({ user: null, token: localStorage.getItem("token") }),
  getters: { isLoggedIn: (s) => !!s.token },
  actions: {
    async login(form) {
      const { data } = await client.post("/login", form);
      this.token = data.token;
      this.user = data.user;
      localStorage.setItem("token", data.token);
    },
    async logout() {
      try {
        await client.post("/logout");
      } finally {
        this.clearSession();
      }
    },
    async fetchUser() {
      const { data } = await client.get("/me");
      this.user = data.data;
    },
    clearSession() {
      this.token = null;
      this.user = null;
      localStorage.removeItem("token");
    },
  },
});
