<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: null,
    email: null,
    password: null,
})
</script>

<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
      <h2 class="text-center mb-4">Register</h2>

      <form @submit.prevent="form.post('/register')">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input
            type="text"
            id="name"
            v-model="form.name"
            class="form-control"
            :class="{ 'is-invalid': form.errors.name }"
          />
          <div class="invalid-feedback" v-if="form.errors.name">
            {{ form.errors.name }}
          </div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            class="form-control"
            :class="{ 'is-invalid': form.errors.email }"
          />
          <div class="invalid-feedback" v-if="form.errors.email">
            {{ form.errors.email }}
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            class="form-control"
            :class="{ 'is-invalid': form.errors.password }"
          />
          <div class="invalid-feedback" v-if="form.errors.password">
            {{ form.errors.password }}
          </div>
        </div>

        <div class="d-grid mb-3">
          <button class="btn btn-primary" type="submit" :disabled="form.processing">
            Register
          </button>
        </div>
      </form>

      <p class="text-center mt-3 mb-0">
        Already have an account?
        <a href="/login" class="text-decoration-none">Login</a>
      </p>
    </div>
  </div>
</template>

