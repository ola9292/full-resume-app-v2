<script setup>
import Nav from '../Shared/Nav.vue'
defineProps({
  resumes: Array,
  user: Object
});

</script>

<template>
    <Nav />
    <div class="container mt-4">
        <h1>Profile Page</h1>

        <div class="card mb-4">
            <div class="card-body">
                Name: {{ user.name }} <br>
                Email: {{ user.email }}
            </div>
        </div>


        <div v-if="resumes.length > 0">

                <div class="card text-bg-success mb-3" v-for="resume in resumes" :key="resume.id">
                    <div class="card-header">{{ resume.role }}</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ resume.name }}</h5>
                        <p class="card-text">{{ resume.summary }}</p>
                        <a :href="`preview/${resume.id}`" class="btn btn-outline-info me-2">Preview <i class="fa-solid fa-magnifying-glass"></i></a>
                        <a :href="`resume/${resume.id}/edit`" class="btn btn-outline-warning">edit <i class="fa-solid fa-user-pen"></i></a>
                    </div>

                </div>


        </div>
        <div v-else>
            <div class="alert alert-secondary" role="alert">
                You have now resumes.
            </div>
            <a href="/resume">Create Resume</a>
        </div>


    </div>
</template>
<style scoped>
    a{
        text-decoration: none;
    }
</style>