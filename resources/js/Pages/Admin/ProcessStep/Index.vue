<template>

    <Head>
        <title>Alur Terstruktur − Admin {{ setting.site_title }}</title>
    </Head>

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-7 py-lg-8">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <ol class="breadcrumb text-muted fs-6 fw-semibold mb-3">
                            <li class="breadcrumb-item pe-3">
                                <Link href="/admin/dashboard" class="btn-link-myprimary fw-bolder pe-3">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item pe-3 text-muted">Alur Terstruktur</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Alur Terstruktur</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl px-0">
                    <form @submit.prevent="submit">
                        <div class="row g-6">
                            <div v-for="(step, index) in form.steps" :key="step.id" class="col-12 col-lg-4">
                                <div class="card h-100 rounded-4 border border-gray-300 bg-white">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="mb-0 fw-bolder">Langkah {{ index + 1 }}</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <input type="hidden" v-model="step.id">
                                        <input type="hidden" v-model="step.position">

                                        <div class="mb-5 fv-row">
                                            <label class="required form-label fs-6">Judul</label>
                                            <input type="text" required class="form-control rounded-3 fs-5"
                                                v-model="step.title" placeholder="Contoh: Unggah Dokumen">
                                        </div>

                                        <div class="fv-row">
                                            <label class="required form-label fs-6">Deskripsi</label>
                                            <textarea required class="form-control rounded-3 fs-5" rows="5"
                                                v-model="step.description"
                                                placeholder="Tulis deskripsi singkat alur..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-7">
                            <button type="submit" id="submit_button"
                                class="btn btn-sm btn-myprimary-filled rounded-3 fw-bolder fs-5">
                                <span class="indicator-label">Simpan Perubahan</span>
                                <span class="indicator-progress">
                                    Mohon Tunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';

export default {
    layout: LayoutAdmin,

    components: {
        Head,
        Link,
    },

    props: {
        setting: Object,
        process_steps: {
            type: Array,
            default: () => [],
        },
        errors: Object,
    },

    setup(props) {
        const form = reactive({
            steps: props.process_steps.map((step) => ({
                id: step.id,
                position: step.position,
                title: step.title,
                description: step.description,
            })),
        });

        const submit = () => {
            const submitBtn = document.querySelector('#submit_button');
            if (submitBtn) submitBtn.setAttribute('data-kt-indicator', 'on');

            router.put('/admin/process-steps', { steps: form.steps }, {
                onSuccess: () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Alur Terstruktur Berhasil Diperbarui!',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal-custom-icon',
                        },
                    });
                },
                onFinish: () => {
                    if (submitBtn) submitBtn.removeAttribute('data-kt-indicator');
                },
            });
        };

        return {
            form,
            submit,
        };
    },
};
</script>
