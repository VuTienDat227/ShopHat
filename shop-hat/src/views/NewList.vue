<!-- file: NewsList.vue -->

<template>
    <div>
      <h1>News List</h1>
      <ul>
        <li v-for="news in newsList" :key="news.id">
          <router-link :to="`/news/${news.id}`">{{ news.title }}</router-link>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        newsList: []
      };
    },
    created() {
      this.fetchNewsList();
    },
    methods: {
      fetchNewsList() {
        axios.get('/api/news')
          .then(response => {
            this.newsList = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      }
    }
  }
  </script>
  