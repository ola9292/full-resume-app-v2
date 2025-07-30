<script setup>
import { Link } from '@inertiajs/vue3'
import Nav from '../../Shared/Nav.vue'
import { useForm,usePage } from '@inertiajs/vue3'
import { GoogleGenAI } from "@google/genai"
import { ref } from 'vue'
const props = defineProps({
    gemini_api_key: String
});
const form = useForm({
    name: null,
    role: null,
    location: null,
    email: null,
    phone: null,
    website: null,
    summary: null,
    skills:[
        {
            title:''
        }
    ],
    education: [
        {
        school: '',
        course: '',
        start: '',
        end: '',
        },
    ],
    experience: [
        {
        company: '',
        position: '',
        start: '',
        end: '',
        skills: '',
        description: '',
        },
    ],
})
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
const ai = new GoogleGenAI({ apiKey: props.gemini_api_key });
  // get ai summary
const generateSummary = async () => {

// Destructure personalInfo for easier access
const { name, role, location } = form;

if(!name || !role || !location){
    alert('fill in your name, role and location')
    return
}
// Construct the dynamic prompt using template literals
const prompt = `Write a compelling professional summary for a resume.
Name: ${name}
Role: ${role}
Location: ${location}

Write a concise professional summary (2-3 sentences) that highlights their expertise and value proposition as a ${role}. Do not include placeholder text or brackets. Focus on skills, experience level, and what they bring to employers. Make it sound professional and confident without using specific metrics or achievements that aren't provided.`;

    try {
        const response = await ai.models.generateContent({
            model: "gemini-2.0-flash",
            // Use the dynamically created prompt here
            contents: prompt,
        });

        const generatedText = response.text;
        // console.log(generatedText);

        // Update the summary in your resumeData
        form.summary = generatedText;

    } catch (error) {
        console.error("Error generating AI summary:", error);
        // Optionally, inform the user about the error
        alert("Failed to generate summary. Please try again later.");
    }
};
const generateResponsibilities = async (experienceItem) => {
  // Ensure we have necessary data
  if (!experienceItem || !experienceItem.position || !experienceItem.company || !experienceItem.skills) {
    alert("Please provide a role and company name and skills for the experience.");
    return;
  }
//   console.log(experienceItem)
  const { position, company, skills } = experienceItem;
  const allSkills = skills;

  // Construct the prompt for responsibilities
  const prompt = `Generate 3 concise bullet-point work responsibilities for a resume.
    Role: ${position}
    Company: ${company}
    Skills: ${allSkills}
    Each responsibility should be a single sentence focusing on impact and using action verbs. Present them as a numbered list.`;

  try {
    const response = await ai.models.generateContent({
      model: "gemini-2.0-flash",
      contents: prompt,
    });
    const generatedText = response.text;
    // console.log("Generated Responsibilities:", generatedText);

    // Parse the generated text into an array of sentences/bullet points
    // This part might need refinement based on actual AI output format
    const parsedResponsibilities = generatedText
        .split('\n')
        .filter(line => line.trim() !== '') // Remove empty lines
        .filter(line => /^\d+\./.test(line.trim())) // Only keep lines that start with numbers
         .map(line => {
            // Remove the numbering (1., 2., etc.) and clean up
            let cleaned = line.replace(/^\d+\.\s*/, '').trim();
            // Add period if it doesn't end with one
            if (!cleaned.endsWith('.')) {
            cleaned += '.';
            }
            return cleaned;
        })
        .join('\n');

    //Update the responsibilities array for the specific experience item
    experienceItem.description = parsedResponsibilities;

  } catch (error) {
    //console.error(`Error generating responsibilities for ${role} at ${company}:`, error);
    alert("Failed to generate responsibilities. Please try again later.");
  }
};
</script>
<template>
    <Nav />
    <section class="container mt-4">
        <Transition>
              <div class="progress mb-2" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div v-if="step == 1" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 25%"></div>
                    <div v-if="step == 2" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 50%"></div>
                    <div v-if="step == 3" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 75%"></div>
                    <div v-if="step == 4" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                </div>
        </Transition>

        <form @submit.prevent="form.post('/resume')">
            <div v-if="Object.keys(form.errors).length" class="alert alert-danger mb-4 mt-4">
                <ul class="mb-0">
                <li v-for="([message], index) in Object.entries(form.errors)" :key="index">
                    {{ message }}
                </li>
                </ul>
            </div>
            <div class="border p-3 mb-3" v-if="step == 1">
                <h1>Personal Information</h1>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="john doe" v-model="form.name">

                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Role</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Software Developer" v-model="form.role">

                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Location</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="San Francisco" v-model="form.location">

                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="johndoe@gmail.com" v-model="form.email">

                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="09836374887" v-model="form.phone">

                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Website Url</label>
                    <input type="url" class="form-control" id="exampleFormControlInput1" placeholder="www.johndoe.com" v-model="form.website">

                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Summary</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="form.summary"></textarea>
                </div>
                <div class="">
                    <button type="button" @click="generateSummary()" class="btn btn-outline-success"><i class="fa-solid fa-wand-magic-sparkles"></i> Ai Summary</button>
                </div>
            </div>

            <!-- Education -->
            <div class="education" v-if="step == 2">
                <h2>Education</h2>
                <div class="mb-4 border p-3" v-for="(edu, index) in form.education" :key="index">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">School</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Havard" v-model="edu.school">
                        <!-- <div v-if="form.errors[`education.${index}.school`]">
                            The education field is required
                            </div> -->
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Course</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Software Engineering" v-model="edu.course">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Start Date</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="july 2020" v-model="edu.start">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">End date</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="june 2021" v-model="edu.end">
                    </div>
                    <button type="button" class="btn btn-outline-danger" @click="removeEducation(index)">Remove</button>
                </div>
                <div class="mt-4 mb-4">
                    <button type="button" class="btn btn-outline-success" @click="addEducation">Add Education</button>
                </div>

            </div>

            <!-- skills -->
            <div class="border p-3 mb-3" v-if="step == 3">
                <h2>Skills</h2>
                <div v-for="(skill, index) in form.skills" :key="index" class="d-flex align-items-center gap-2 mb-2">
                    <input type="text" v-model="skill.title" placeholder="Javascript" class="form-control"/>
                    <button type="button" class="btn btn-outline-danger" @click="removeSkill(index)">
                        &times;
                    </button>
                </div>
                <div class="mt-4 mb-4">
                    <button type="button" class="btn btn-outline-success" @click.prevent="addSkill">Add Skill</button>
                </div>

            </div>
           <!-- EXPERIENCE -->
            <div v-if="step == 4">
                <h2>Experience</h2>
                <div class="border p-3 mb-3" v-for="(ex, index) in form.experience" :key="index">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Google" v-model="ex.company">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Position</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Software Developer" v-model="ex.position">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Start Date</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="july 2020" v-model="ex.start">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">End date</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="june 2021" v-model="ex.end">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Skills</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Html, Css, js" v-model="ex.skills">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Job Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="ex.description"></textarea>
                    </div>

                    <button type="button" class="btn btn-outline-danger me-2" @click="removeExperience(index)">Remove</button>
                    <button type="button" @click="generateResponsibilities(ex)" class="btn btn-outline-success"><i class="fa-solid fa-wand-magic-sparkles"></i> Ai Assist</button>

                </div>
                <div class="mt-4 mb-4">
                    <button type="button" class="btn btn-outline-success" @click="addExperience">Add Experience</button>
                </div>

            </div>
            <div v-if="step == 4" class="mb-2">
                  <button type="submit" class="btn btn-primary" :disabled="form.processing">
                    <span v-if="form.processing">Submitting...</span>
                    <span v-else>Submit</span>
                </button>
            </div>
         </form>
    </section>

    <div class="container mb-5">
        <button class="btn btn-outline-secondary me-2" @click="prev" :disabled="step == 1"><i class="fa-solid fa-angle-left"></i> Previous</button>
        <button class="btn btn-outline-warning" @click="next" :disabled="step == 4">Next <i class="fa-solid fa-angle-right"></i></button>
    </div>

</template>

<style scoped>

</style>