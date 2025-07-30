<script setup>
import { ref} from 'vue'
const props = defineProps({
  resume: Object,
  resumeId: [String, Number]
});

const isDownloading = ref(false)

const downloadPDF = async () => {
  if (isDownloading.value) return

  try {
    isDownloading.value = true

    // Create a temporary anchor element for download
    const link = document.createElement('a')
    link.href = `/resume/${props.resume.id}/download`
    link.target = '_blank'

    // Trigger download
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)

  } catch (error) {
    console.error('Download failed:', error)
    alert('Failed to download PDF. Please try again.')
  } finally {
    isDownloading.value = false
  }
}

    const previewPDF = () => {
    // Open PDF in new tab for preview
    window.open(`/resume/${props.resume.id}/view`, '_blank')
    }
</script>

<template>
  <div class="resume-preview">
    <!-- Header Section -->
    <header class="resume-header">
      <h1 class="name">{{ resume?.name || 'Your Name' }}</h1>
      <h2 class="role">{{ resume?.role || 'Your Role' }}</h2>

      <div class="contact-info">
        <div class="contact-item" v-if="resume?.email">
          <span>{{ resume.email }}</span>
        </div>
        <div class="contact-item" v-if="resume?.phone">
          <span>{{ resume.phone }}</span>
        </div>
        <div class="contact-item" v-if="resume?.location">
          <span>{{ resume.location }}</span>
        </div>
        <div class="contact-item" v-if="resume?.website">
          <span>{{ resume.website }}</span>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="resume-content">
      <!-- Summary Section -->
      <section class="resume-section" v-if="resume?.summary">
        <h3 class="section-title">SUMMARY</h3>
        <p class="summary-text">{{ resume.summary }}</p>
      </section>

      <!-- Skills Section -->
      <section class="resume-section" v-if="resume?.skills && resume.skills.length > 0">
        <h3 class="section-title">SKILLS</h3>
        <div class="skills-container">
          <span
            v-for="(skill, index) in resume.skills"
            :key="index"
            class="skill-pill"

          >
            {{ skill.title }}
          </span>
        </div>
      </section>

      <!-- Experience Section -->
      <section class="resume-section" v-if="resume?.job_experience && resume.job_experience.length > 0">
        <h3 class="section-title">EXPERIENCE</h3>
        <div class="experience-list">
          <div
            v-for="(job, index) in resume.job_experience"
            :key="index"
            class="experience-item"

          >
            <div class="experience-header">
              <div class="job-details">
                <h4 class="job-position">{{ job.position || 'Position' }}</h4>
                <p class="job-company">{{ job.company || 'Company' }}</p>
              </div>
              <div class="job-dates">
                {{ job.start }} - {{ job.end || 'Present' }}
              </div>
            </div>
            <p class="job-skills" v-if="job.skills">
              <strong>Skills:</strong> {{ job.skills }}
            </p>
            <ul class="job-description" v-if="job.description">
                <li v-for="(line, i) in job.description.split('\n')" :key="i">
                    {{ line }}
                </li>
            </ul>

          </div>
        </div>
      </section>

      <!-- Education Section -->
      <section class="resume-section" v-if="resume?.education && resume.education.length > 0">
        <h3 class="section-title">EDUCATION</h3>
        <div class="education-list">
          <div
            v-for="(edu, index) in resume.education"
            :key="index"
            class="education-item"

          >
            <div class="education-header">
              <div class="education-details">
                <h4 class="education-course">{{ edu.course || 'Course' }}</h4>
                <p class="education-school">{{ edu.school || 'School' }}</p>
              </div>
              <div class="education-dates">
                {{ edu.start }} - {{ edu.end || 'Present' }}
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

<div class="container mt-4 d-flex justify-content-center">
     <div class="download-section">
        <div class="download-actions">
            <button
                @click="downloadPDF"
                :disabled="isDownloading"
                class="btn btn-secondary me-2"
            >
                <span v-if="isDownloading" class="loading-spinner"></span>
                {{ isDownloading ? 'Generating PDF...' : 'Download PDF' }}
            </button>

            <button
                @click="previewPDF"
                class="btn btn-primary me-2"
            >
                Preview PDF
            </button>
            <a href="/profile" class="btn btn-outline-success">Back to profile</a>
        </div>

        <p class="download-note">
        Your resume will be downloaded as a professional PDF document.
        </p>
    </div>
</div>

</template>

<style scoped>
.resume-preview {
  max-width: 800px;
  margin: 0 auto;
  background: #ffffff;
  border: 1px solid #e0e0e0;
  font-family: 'Arial', sans-serif;
  line-height: 1.5;
  color: #000000;
  padding: 40px;
}

/* Header Styles */
.resume-header {
  text-align: center;
  padding-bottom: 30px;
  border-bottom: 2px solid #000000;
  margin-bottom: 30px;
}

.name {
  font-size: 2.2rem;
  font-weight: bold;
  margin: 0 0 8px 0;
  color: #000000;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.role {
  font-size: 1.2rem;
  font-weight: normal;
  margin: 0 0 20px 0;
  color: #333333;
}

.contact-info {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
}

.contact-item {
  font-size: 0.9rem;
  color: #333333;
}

.contact-item:not(:last-child)::after {
  content: ' | ';
  margin-left: 15px;
  color: #666666;
}

/* Content Styles */
.resume-content {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.resume-section {
  margin: 0;
}

.section-title {
  font-size: 1.1rem;
  font-weight: bold;
  color: #000000;
  margin: 0 0 15px 0;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-bottom: 1px solid #000000;
  padding-bottom: 5px;
}

/* Summary Styles */
.summary-text {
  color: #333333;
  font-size: 0.95rem;
  margin: 0;
  text-align: justify;
}

/* Skills Styles */
.skills-container {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.skill-pill {
  background: #000000;
  color: #ffffff;
  padding: 6px 12px;
  border-radius: 15px;
  font-size: 0.85rem;
  font-weight: normal;
  display: inline-block;
}

/* Experience Styles */
.experience-list {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.experience-item {
  border-left: 3px solid #000000;
  padding-left: 15px;
}

.experience-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 10px;
  gap: 20px;
}

.job-details {
  flex: 1;
}

.job-position {
  font-size: 1.1rem;
  font-weight: bold;
  color: #000000;
  margin: 0 0 5px 0;
}

.job-company {
  font-size: 0.95rem;
  color: #333333;
  margin: 0;
  font-style: italic;
}

.job-dates {
  font-size: 0.9rem;
  color: #333333;
  white-space: nowrap;
  font-weight: bold;
}

.job-skills {
  font-size: 0.9rem;
  color: #333333;
  margin: 8px 0;
}

.job-description {
  font-size: 0.9rem;
  color: #333333;
  margin: 8px 0 0 0;
  text-align: justify;
}

/* Education Styles */
.education-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.education-item {
  border-left: 3px solid #000000;
  padding-left: 15px;
}

.education-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 20px;
}

.education-details {
  flex: 1;
}

.education-course {
  font-size: 1rem;
  font-weight: bold;
  color: #000000;
  margin: 0 0 5px 0;
}

.education-school {
  font-size: 0.95rem;
  color: #333333;
  margin: 0;
  font-style: italic;
}

.education-dates {
  font-size: 0.9rem;
  color: #333333;
  white-space: nowrap;
  font-weight: bold;
}

/* Responsive Design */
@media (max-width: 768px) {
  .resume-preview {
    padding: 30px 20px;
    margin: 10px;
  }

  .name {
    font-size: 1.8rem;
  }

  .contact-info {
    flex-direction: column;
    gap: 8px;
  }

  .contact-item:not(:last-child)::after {
    display: none;
  }

  .experience-header,
  .education-header {
    flex-direction: column;
    gap: 8px;
  }

  .job-dates,
  .education-dates {
    white-space: normal;
  }
}

@media (max-width: 480px) {
  .name {
    font-size: 1.6rem;
  }

  .section-title {
    font-size: 1rem;
  }
}
</style>