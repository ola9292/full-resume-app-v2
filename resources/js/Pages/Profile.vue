<script setup>
import Nav from '../Shared/Nav.vue'
import { Link, useForm } from '@inertiajs/vue3'

defineProps({
  resumes: Array,
  user: Object
});
const form = useForm({
  avatar: null,
})
function submit() {
  form.post('/user')
}
</script>

<template>
    <Nav />
    <div class="container mt-4">
        <h1>Profile Page</h1>
        <div class="row g-3">
            <div class="col-sm-4 card mb-4">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <div v-if="user.avatar">
                        <img :src="`/storage/${user.avatar}`" alt="User Avatar" width="200" height="200" style="border-radius: 50%;">
                        <div class="mt-3 d-flex align-items-center justify-content-center">
                            <Link class="btn btn-outline-danger" href="user/delete" method="delete">Replace Profile</Link>
                        </div>

                    </div>
                     <div class="" v-if="!user.avatar">
                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="mb-3">
                            <label for="avatar" class="form-label">Upload Avatar</label>
                            <input
                                class="form-control"
                                type="file"
                                id="avatar"
                                @input="form.avatar = $event.target.files[0]"
                            />
                            </div>

                            <div v-if="form.progress" class="mb-3">
                            <label class="form-label">Upload Progress</label>
                                <div class="progress">
                                    <div
                                    class="progress-bar"
                                    role="progressbar"
                                    :style="{ width: form.progress.percentage + '%' }"
                                    :aria-valuenow="form.progress.percentage"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    >
                                    {{ form.progress.percentage }}%
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Upload Avatar</button>
                        </form>
                    </div>
                    <div class="mt-3">
                        <p>Name: {{ user.name }} </p>
                        <p>Email: {{ user.email }}</p>
                    </div>

                </div>



            </div>

            <section class="col-sm-8">
                <div v-if="resumes.length > 0">
                    <div class="card text-bg-success mb-3" v-for="resume in resumes" :key="resume.id">
                        <div class="card-header">{{ resume.role }}</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ resume.name }}</h5>
                            <p class="card-text">{{ resume.summary }}</p>
                            <a :href="`preview/${resume.id}`" class="btn btn-outline-info me-2">Preview <i class="fa-solid fa-magnifying-glass"></i></a>
                            <a :href="`resume/${resume.id}/edit`" class="btn btn-outline-warning me-2">Edit <i class="fa-solid fa-user-pen"></i></a>
                            <Link :href="`resume/${resume.id}/delete`" method="DELETE" class="btn btn-outline-danger">Delete <i class="fa-solid fa-trash-can"></i></Link>
                        </div>

                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-secondary" role="alert">
                        You have now resumes.
                    </div>
                    <a href="/resume">Create Resume</a>
                </div>
            </section>
        </div>
    </div>
</template>
<style scoped>
    a{
        text-decoration: none;
    }
</style>