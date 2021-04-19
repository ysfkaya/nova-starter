<template>
  <div v-if="currentlyInMaintenance">
    <div class="w-full py-2 bg-primary mb-5">
      <div class="flex items-center justify-center">
        <div class="flex text-white">
          <svg
            fill="var(--primary)"
            width="24"
            height="24"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            />
          </svg>
        </div>
        <div class="text-white">
          {{ __('You are currently in Maintenance Mode') }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentlyInMaintenance: Nova.config.currentlyInMaintenanceMode,
    };
  },
  mounted() {
    Nova.$on("maintenance-mode", (value) => {
      this.$nextTick(() => {
        this.currentlyInMaintenance = value;
      });
    });
  },
};
</script>

