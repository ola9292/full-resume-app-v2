<script setup>
import { Link } from '@inertiajs/vue3'

import { ref } from 'vue'
</script>

<template>
    <!-- <div class="main-menu">
        <header>
            <a href="/">Resume</a>
            <span>Hello {{ $page.props.username }}</span>
        </header>
        <ul>
            <Link v-if="$page.props.isLoggedIn" href="/logout" method="post" class="btn">Logout</Link>
            <Link v-else href="/login" class="btn">Login</Link>
        </ul>
    </div> -->

<nav class="navbar navbar-expand-lg bg-dark text-primary">
  <div class="container-fluid">
    <!-- Left side: Logo and Username -->
    <div class="d-flex align-items-center">
      <a class="navbar-brand text-white me-3" href="/">
        <i class="fa-solid fa-book-open"></i> Smart Res
      </a>
      <span class="text-white">Hello {{ $page.props.username }}</span>
    </div>

    <!-- Hamburger toggler for mobile -->
    <button
      class="navbar-toggler bg-secondary"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Right side: Nav links -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="/resume">Create</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/profile">Profile</a>
        </li>
        <li class="nav-item">
          <Link
            v-if="$page.props.isLoggedIn"
            href="/logout"
            method="post"
            class="btn btn-outline-light ms-2"
          >
            Logout
          </Link>
          <Link
            v-else
            href="/login"
            class="btn btn-outline-light ms-2"
          >
            Login
          </Link>
        </li>
      </ul>
    </div>
  </div>
</nav>


</template>

