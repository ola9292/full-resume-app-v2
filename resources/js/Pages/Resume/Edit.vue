<script setup>
import Nav from '../../Shared/Nav.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
const props = defineProps({
  resume: Object,
  user: Object
});
const step = ref(1)
const next = () => {
    step.value += 1
}
const prev = () => {
    step.value -= 1
}
const addEducation = () =>{
     form.education.push({
        school: '',
        course: '',
        start: '',
        end: '',
    })
}
const removeEducation = (index) => {
    form.education.splice(index, 1)
}
const addExperience = () =>{
     form.experience.push({
       company: '',
        position: '',
        start: '',
        end: '',
        skills: '',
        description: '',
    })
}
const removeExperience = (index) => {
    form.experience.splice(index, 1)
}
const addSkill = () =>{
    form.skills.push({title:''})
}
const removeSkill = (index) =>{
    form.skills.splice(index, 1)
}
const addCertification = () =>{
     form.certification.push({
        name:'',
        institution:'',
        year:''
    })
}
const removeCertification = (index) => {
    form.certification.splice(index, 1)
}
const addProject = () =>{
     form.projects.push({
        name:'',
        link:'',
        year:'',
        description:''
    })
}
const removeProject = (index) => {
    form.projects.splice(index, 1)
}
const form = useForm({
  name: props.resume.name ?? '',
  role: props.resume.role ?? '',
  location: props.resume.location ?? '',
  email: props.resume.email ?? '',
  phone: props.resume.phone ?? '',
  website: props.resume.website ?? '',
  summary: props.resume.summary ?? '',
  education: props.resume.education ?? [],
  experience: props.resume.job_experience ?? [],
  skills: props.resume.skills ?? [],
  certification: props.resume.certification ?? [],
  projects: props.resume.projects ?? [],
})
</script>

<template>
    <Nav />
    <div class="container mt-4">

        <div class="progress mb-2" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div v-if="step == 1" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 20%"></div>
            <div v-if="step == 2" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 40%"></div>
            <div v-if="step == 3" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 60%"></div>
            <div v-if="step == 4" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 80%"></div>
            <div v-if="step == 5" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
        </div>

        <h1 class="mb-3">Edit Page</h1>
        <div class="mb-3">
             <a href="/profile">
          <i class="fa-regular fa-circle-left"></i> Back to profile
        </a>
        </div>

         <form @submit.prevent="form.put(`/resume/${props.resume.id}/edit`)">
            <div v-if="Object.keys(form.errors).length" class="alert alert-danger mb-4 mt-4">
                <ul class="mb-0">
                <li v-for="([message], index) in Object.entries(form.errors)" :key="index">
                    {{ message }}
                </li>
                </ul>
            </div>
            <div v-if="step == 1">
                <div class="border p-3 mb-3">
                    <h3 class="mb-2">Personal Information</h3>
                    <input type="text" v-model="form.name" placeholder="Full Name" class="form-control mb-2" />
                    <input type="text" v-model="form.role" placeholder="Role" class="form-control mb-2" />
                    <input type="text" v-model="form.location" placeholder="Location" class="form-control mb-2" />
                    <input type="email" v-model="form.email" placeholder="Email" class="form-control mb-2" />
                    <input type="text" v-model="form.phone" placeholder="Phone" class="form-control mb-2" />
                    <input type="url" v-model="form.website" placeholder="Website" class="form-control mb-2" />
                    <textarea v-model="form.summary" placeholder="Summary" class="form-control mb-2"></textarea>
                </div>
            </div>

            <div v-if="step == 2">
                <div class="border p-3">
                    <h3 class="mb-2">Education information</h3>
                    <div v-for="(edu, index) in form.education" :key="index" class="border p-3 mb-3 rounded">
                        <input type="text" v-model="edu.school" placeholder="School" class="form-control mb-2"/>
                        <input type="text" v-model="edu.course" placeholder="Course" class="form-control mb-2"/>
                        <input type="text" v-model="edu.start" placeholder="Start Year" class="form-control mb-2"/>
                        <input type="text" v-model="edu.end" placeholder="End Year" class="form-control mb-2"/>

                        <button type="button" class="btn btn-outline-danger btn-sm" @click="removeEducation(index)">Remove</button>
                    </div>
                    <button type="button" class="btn btn-outline-success" @click="addEducation">Add Education</button>
                </div>

            </div>

            <div v-if="step == 3">
                <!-- Skills Section -->
                 <div class="border p-3">
                      <h3 class="mb-2">Skills</h3>
                        <div v-for="(skill, index) in form.skills" :key="index" class="d-flex align-items-center gap-2 mb-2">
                            <input type="text" v-model="skill.title" placeholder="Skill" class="form-control"/>
                            <button type="button" class="btn btn-outline-danger" @click="removeSkill(index)">
                                &times;
                            </button>
                        </div>
                        <button type="button" class="btn btn-outline-success mb-4" @click="addSkill">Add Skill</button>
                 </div>

            </div>

            <div v-if="step == 4">
                <!-- Experience Section: Horizontal layout -->
                 <div class="border p-3">
                    <h3 class="mb-2">Experience</h3>
                    <div v-for="(exp, index) in form.experience" :key="index" class="border p-3 mb-3 rounded">
                            <input type="text" v-model="exp.position" placeholder="Position" class="form-control mb-1"/>
                            <input type="text" v-model="exp.company" placeholder="Company" class="form-control mb-1"/>
                            <input type="text" v-model="exp.start" placeholder="Start Date" class="form-control mb-1"/>
                            <input type="text" v-model="exp.end" placeholder="End Date" class="form-control mb-1"/>
                            <input type="text" v-model="exp.skills" placeholder="Skills (comma separated)" class="form-control mb-1"/>
                            <textarea v-model="exp.description" placeholder="Description" class="form-control" rows="2"></textarea>
                            <button
                                type="button"
                                class="btn btn-outline-danger mt-3"
                                @click="removeExperience(index)"
                                >
                                Remove
                            </button>
                        </div>
                    <button type="button" class="btn btn-outline-success mb-4" @click="addExperience">
                        Add Experience
                    </button>
                 </div>
            </div>

            <div v-if="step == 5">
                <h2>Certifications</h2>
                <div class="accordion accordion-flush border" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                           <span class="me-2">Courses and Certifications</span>  <span class="badge text-bg-primary">{{ form.certification.length }} {{ form.certification.length <= 1 ? 'Item' : 'Items' }}</span>
                        </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div v-for="(cert, index) in form.certification" :key="index" class="row g-3 border pb-2 mt-3">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <p>Certification {{ index + 1}}</p>
                                        <button type="button" class="btn btn-outline-danger" @click="removeCertification(index)">
                                            &times;
                                        </button>
                                    </div>
                                    <div class="col">
                                        <label for="exampleFormControlInput1" class="form-label">Title/Name</label>
                                        <input type="text" class="form-control" placeholder="Name" aria-label="" v-model="cert.name">
                                    </div>
                                    <div class="col">
                                        <label for="exampleFormControlInput1" class="form-label">Organization/Institution</label>
                                        <input type="text" class="form-control" placeholder="Institution" v-model="cert.institution">
                                    </div>
                                    <div class="col">
                                        <label for="exampleFormControlInput1" class="form-label">Year</label>
                                        <input type="text" class="form-control" placeholder="Year" v-model="cert.year">
                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="button" class="btn btn-outline-secondary" @click="addCertification">Add Courses & Certifications</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                  <div class="accordion accordion-flush border" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                           <span class="me-2">Projects</span>  <span class="badge text-bg-primary">{{ form.projects.length }} {{ form.projects.length <= 1 ? 'Item' : 'Items' }}</span>
                        </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div v-for="(project, index) in form.projects" :key="index" class="row g-3 border pb-2 mt-3">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <p>Project {{ index + 1}}</p>
                                        <button type="button" class="btn btn-outline-danger" @click="removeProject(index)">
                                            &times;
                                        </button>
                                    </div>
                                    <div class="col">
                                        <label for="exampleFormControlInput1" class="form-label">Title/Name</label>
                                        <input type="text" class="form-control" placeholder="Name" aria-label="" v-model="project.name">
                                    </div>
                                    <div class="col">
                                        <label for="exampleFormControlInput1" class="form-label">Project Link</label>
                                        <input type="text" class="form-control" placeholder="Institution" v-model="project.link">
                                    </div>
                                    <div class="col">
                                        <label for="exampleFormControlInput1" class="form-label">Year</label>
                                        <input type="text" class="form-control" placeholder="Year" v-model="project.year">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Project Description</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="project.description"></textarea>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="d-grid gap-2 mt-3">
                                    <button type="button" class="btn btn-outline-secondary" @click="addProject">Add Project</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-3" v-if="step == 5">
                <button class="btn btn-primary">Update Resume</button>
            </div>

             <div class="mb-4 mt-4">
                <button type="button" class="btn btn-outline-secondary me-2" @click="prev" :disabled="step == 1"><i class="fa-solid fa-angle-left"></i> Previous</button>
                <button type="button" class="btn btn-outline-warning" @click="next" :disabled="step == 5">Next <i class="fa-solid fa-angle-right"></i></button>
            </div>


  </form>
    </div>
</template>
<style scoped>
    a{
        text-decoration: none;
    }
    .progress-bar {
  transition: width 0.5s ease-in-out;
}
</style>