<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email: null,
    password: null,
})
</script>

<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
      <h2 class="text-center mb-4">Login</h2>

      <form @submit.prevent="form.post('/login')">
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
            Login
          </button>
        </div>
      </form>

      <p class="text-center mt-3 mb-0">
        Don’t have an account?
        <a href="/register" class="text-decoration-none">Register</a>
      </p>
    </div>
  </div>
</template>

