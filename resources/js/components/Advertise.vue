<template>
    <iframe
      :src="link"
      type="application/pdf"
      frameBorder="0"
      scrolling="auto"
      height="600px"
      width="100%"
    ></iframe>
</template>

<script>
export default {
  data() {
    return {
      link: "/pdf/voc_1.pdf",
    };
  },
};
</script>
