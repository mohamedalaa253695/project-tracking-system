<template>
    <h1>
        <a class="navbar-brand" href="/projects">
            <img class="w-36" :src="logoPath" alt="logo" />
        </a>
    </h1>
</template>

<script>
// import { useRouter } from "vue-router";
// const router = useRouter();

export default {
    data() {
        return {
            logoPath: `${window.location.origin}/images/logo.svg`,
        };
    },

    created() {
        console.log(`${window.location.origin}/images/logo.svg`);
        this.logoPath =
            localStorage.getItem("logo") ||
            `${window.location.origin}/images/logo.svg`;
        Event.$on("switched", (theme) =>
            theme == "theme-light"
                ? (this.logoPath = `${window.location.origin}/images/logo.svg`) &&
                  localStorage.setItem(
                      "logo",
                      `${window.location.origin}/images/logo.svg`
                  )
                : (this.logoPath = `${window.location.origin}/images/logo-light.svg`) &&
                  localStorage.setItem(
                      "logo",
                      `${window.location.origin}/images/logo-light.svg`
                  )
        );
    },
};
</script>

<style></style>
