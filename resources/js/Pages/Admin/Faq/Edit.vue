<template>

    <Head>
        <title>Edit FAQ − Admin {{ setting.site_title }}</title>
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
                            <li class="breadcrumb-item pe-3">
                                <Link href="/admin/faqs" class="btn-link-myprimary fw-bolder pe-3">FAQ</Link>
                            </li>
                            <li class="breadcrumb-item pe-3 text-muted">Edit</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Edit FAQ</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl px-0">
                    <form @submit.prevent="submit">
                        <div class="row g-6">
                            <div class="col-md-4">
                                <div class="card rounded-4 border border-gray-300">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="mb-0 fw-bolder">Informasi Umum</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div class="mb-5 fv-row">
                                            <label class="required form-label fs-6">Pertanyaan</label>
                                            <textarea class="form-control rounded-3 fs-5" data-kt-autosize="true" rows="4"
                                                required placeholder="Masukkan pertanyaan disini..."
                                                v-model="form.question" :class="{ 'is-invalid': errors.question }">
                                            </textarea>
                                            <div v-if="errors.question" class="text-mydanger mt-2">
                                                {{ errors.question }}
                                            </div>
                                        </div>
                                        <div class="fv-row">
                                            <label class="required form-label fs-6">Status</label>
                                            <div class="btn-group w-100" data-kt-buttons="true"
                                                data-kt-buttons-target="[data-kt-button]">
                                                <label
                                                    class="btn btn-active-myprimary text-gray-700 rounded-3 rounded-end-0 fw-bolder text-hover-white text-active-white btn-outline"
                                                    data-kt-button="true"
                                                    :class="{ active: form.status === 'published' }">
                                                    <input class="btn-check" type="radio" v-model="form.status"
                                                        value="published" />
                                                    Terbit
                                                </label>
                                                <label
                                                    class="btn btn-active-mydanger text-gray-700 rounded-3 rounded-start-0 fw-bolder text-hover-white text-active-white btn-outline"
                                                    data-kt-button="true"
                                                    :class="{ active: form.status === 'archived' }">
                                                    <input class="btn-check" type="radio" v-model="form.status"
                                                        value="archived" />
                                                    Arsip
                                                </label>
                                            </div>
                                            <div v-if="errors.status" class="text-mydanger mt-2">
                                                {{ errors.status }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card rounded-4 border border-gray-300">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="required fw-bolder mb-0">Jawaban FAQ</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div class="fv-row">
                                            <Editor
                                                :api-key="api_tinymce_key"
                                                v-model="form.answer"
                                                :init="editorInit"
                                            />
                                            <div v-if="errors.answer" class="text-mydanger mt-2">
                                                {{ errors.answer }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-7">
                            <Link href="/admin/faqs" type="button" class="btn btn-sm btn-mytertiary-tinted rounded-3 fw-bolder fs-5 me-3">Batal</Link>
                            <button type="submit" id="submit_button"
                                class="btn btn-sm btn-myprimary-filled rounded-3 fw-bolder fs-5">
                                <span class="indicator-label">
                                    Edit FAQ
                                </span>
                                <span class="indicator-progress">
                                    Mohon Tunggu... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
    import Editor from '@tinymce/tinymce-vue';

    export default {
        layout: LayoutAdmin,

        components: {
            Head,
            Link,
            Editor
        },

        props: {
            setting: Object,
            errors: Object,
            faq: Object,
            api_tinymce_key: String,
        },

        setup(props) {
            const form = reactive({
                question: props.faq.question,
                answer: props.faq.answer,
                status: props.faq.status,
            });

            const editorInit = {
                menubar: false,
                plugins: 'advlist lists link autoresize',
                toolbar:
                    'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link',
                min_height: 300,
                max_height: 600,
                forced_root_block: 'p',
                block_formats: 'Paragraph=p',
                content_style: `
                    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
                    body {
                        font-family: 'Montserrat', sans-serif;
                    }
                `
            };

            const submit = () => {
                const submitBtn = document.querySelector('#submit_button');
                if (submitBtn) {
                    submitBtn.setAttribute('data-kt-indicator', 'on');
                    submitBtn.setAttribute('disabled', true);
                }

                const cleanup = () => {
                    if (submitBtn) {
                        submitBtn.removeAttribute('data-kt-indicator');
                        submitBtn.removeAttribute('disabled');
                    }
                };

                router.put(`/admin/faqs/${props.faq.id}`, {
                    question: form.question,
                    answer: form.answer,
                    status: form.status,
                }, {
                    onSuccess: () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data FAQ Berhasil Diperbarui!',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'swal-custom-icon',
                            }
                        });
                    },
                    onFinish: cleanup
                });
            };

            return {
                form,
                editorInit,
                submit,
            };
        }
    }
</script>

<style>

</style>
