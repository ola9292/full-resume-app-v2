<script setup>
import { Link } from '@inertiajs/vue3'
import Nav from '../Shared/Nav.vue'
</script>

<template>
  <Nav />

  <!-- Hero Section -->
  <section class="hero-section d-flex align-items-center text-center" style="min-height: 50vh; background-color: #f8f9fa;">
    <div class="container">
      <h1 class="display-4 mb-3">Build Your Resume Effortlessly</h1>
      <p class="lead mb-4">Create a professional resume in minutes with our simple tool.</p>

      <div class="d-flex justify-content-center gap-3">
        <Link
          v-if="$page.props.isLoggedIn"
          href="/resume"
          class="btn btn-primary btn-lg"
        >
          Create Resume
        </Link>
        <Link
          v-else
          href="/login"
          class="btn btn-outline-secondary btn-lg"
        >
          Login to Get Started
        </Link>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-5 bg-white">
    <div class="container">
      <div class="row text-center">
        <!-- Card 1: ATS Compliance -->
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-lg border-0">
            <div class="card-body">
              <i class="fa-solid fa-file-lines fa-2x mb-3 text-primary"></i>
              <h5 class="card-title">ATS Compliance</h5>
              <p class="card-text">Your resume is formatted to be easily parsed by applicant tracking systems so you never get lost in the pile.</p>
            </div>
          </div>
        </div>

        <!-- Card 2: AI Assistance -->
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-lg border-0">
            <div class="card-body">
              <i class="fa-solid fa-robot fa-2x mb-3 text-success"></i>
              <h5 class="card-title">AI Assistance</h5>
              <p class="card-text">Get intelligent suggestions for summaries and job descriptions tailored to your skills and experience.</p>
            </div>
          </div>
        </div>

        <!-- Card 3: PDF Preview & Download -->
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-lg border-0">
            <div class="card-body">
              <i class="fa-solid fa-file-pdf fa-2x mb-3 text-danger"></i>
              <h5 class="card-title">PDF Preview & Download</h5>
              <p class="card-text">Instantly preview and download your resume in high-quality PDF format, ready to share or print.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

