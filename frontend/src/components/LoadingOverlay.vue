<template>
    <v-overlay
      data-testid="increment-overlay"
      :opacity="1"
      :value="loading"
    >
      <v-progress-circular data-testid="increment-progress" indeterminate color="purple" :width="15" size="100">
        Loading
      </v-progress-circular>
    </v-overlay>
</template>

<script>
export default {
    name: 'LoadingOverlay',
    props: {
        loading: Boolean
    },
    data() {
        return {
        }
    },
}
</script>