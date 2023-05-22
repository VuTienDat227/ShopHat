<template>
  <div class="text-center alert alert-danger">
    BẠN KHÔNG CÓ QUYỀN TRUY CẬP<br>
    SẼ TỰ ĐỘNG CHUYỂN HƯỚNG VỀ TRANG CHỦ SAU {{ countdown }}s
  </div>
</template>

<script>
export default {
  name: "404",
  data() {
    return {
      countdown: 10
    };
  },
  mounted() {
    this.startCountdown();
  },
  methods: {
    startCountdown() {
      const timer = setInterval(() => {
        this.countdown--;
        if (this.countdown === 0) {
          clearInterval(timer);
          this.$router.push("/").then(()=>{
            window.location.reload();
          });
        }
      }, 1000);
    }
  }
};
</script>

<style scoped>
</style>
