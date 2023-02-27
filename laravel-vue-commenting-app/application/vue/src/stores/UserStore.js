import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => {
    return {
      token: null,
      data: null
    };
  },
  persist: true
})