<template>

    <Head>
        <title>Tambah Kategori Naskah − Admin {{ setting.site_title }}</title>
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
                                <Link href="/admin/manuscript-categories" class="btn-link-myprimary fw-bolder pe-3">Kategori Naskah</Link>
                            </li>
                            <li class="breadcrumb-item pe-3 text-muted">Tambah</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Tambah Kategori</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl px-0">
                    <form @submit.prevent="submit">
                        <div class="row g-6">
                            <div class="col-md-6 col-xl-5">
                                <div class="card rounded-4 border border-gray-300">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="mb-0 fw-bolder">Informasi Umum</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div class="mb-5 fv-row">
                                            <label class="required form-label fs-6">Judul</label>
                                            <textarea class="form-control rounded-3 fs-5" rows="2"
                                                required placeholder="Masukkan judul disini..."
                                                v-model="form.title" :class="{ 'is-invalid': errors.title }"></textarea>
                                            <div v-if="errors.title" class="text-mydanger mt-2">{{ errors.title }}</div>
                                        </div>
                                        <div class="fv-row">
                                            <label class="required form-label fs-6">Deskripsi</label>
                                            <textarea class="form-control rounded-3 fs-5" rows="4"
                                                required placeholder="Masukkan deskripsi disini..."
                                                v-model="form.description" :class="{ 'is-invalid': errors.description }"></textarea>
                                            <div v-if="errors.description" class="text-mydanger mt-2">{{ errors.description }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-4 border border-gray-300 mt-6">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="required fw-bolder mb-0">Gambar Kategori</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div id="category-dropzone" class="dropzone border-dashed border-myprimary rounded-3 p-5 text-center">
                                            <div class="dz-message needsclick flex-column text-center gap-5 p-5">
                                                <i class="ri-image-add-line text-myprimary fs-3x"></i>
                                                <div>
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-2">Jatuhkan file di sini / klik untuk mengunggah.</h3>
                                                    <span class="fs-7 fw-semibold text-gray-600">Maks. 10 MB • Rasio 1:1</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="errors.image" class="text-mydanger mt-2">{{ errors.image }}</div>
                                        <div v-if="imageItemError" class="text-mydanger mt-2">{{ imageItemError }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-7">
                                <div class="card rounded-4 border border-gray-300">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="required fw-bolder mb-0">Persyaratan</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div v-for="(item, index) in form.requirements" :key="`req-${index}`" class="d-flex gap-3 mb-4">
                                            <input type="text" required class="form-control rounded-3 fs-5" v-model="form.requirements[index]" placeholder="Masukkan poin persyaratan..." />
                                            <button type="button" class="btn btn-icon btn-mydanger-tinted rounded-3" @click="removeListItem('requirements', index)" :disabled="form.requirements.length === 1">
                                                <i class="ri-delete-bin-fill fs-3"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-mytertiary-tinted w-100 rounded-3 fw-bolder fs-6" @click="addListItem('requirements')">Tambah Poin</button>
                                        <div v-if="errors.requirements" class="text-mydanger mt-2">{{ errors.requirements }}</div>
                                    </div>
                                </div>
                                <div class="card rounded-4 border border-gray-300 mt-6">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="required fw-bolder mb-0">Lampiran</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div v-for="(item, index) in form.attachments" :key="`att-${index}`" class="d-flex gap-3 mb-4">
                                            <input required type="text" class="form-control rounded-3 fs-5" v-model="form.attachments[index]" placeholder="Masukkan poin lampiran..." />
                                            <button type="button" class="btn btn-icon btn-mydanger-tinted rounded-3" @click="removeListItem('attachments', index)" :disabled="form.attachments.length === 1">
                                                <i class="ri-delete-bin-fill fs-3"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-mytertiary-tinted w-100 rounded-3 fw-bolder fs-6" @click="addListItem('attachments')">Tambah Poin</button>
                                        <div v-if="errors.attachments" class="text-mydanger mt-2">{{ errors.attachments }}</div>
                                    </div>
                                </div>
                                <div class="card rounded-4 border border-gray-300 mt-6">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="fw-bolder mb-0">Dokumen Terlampir</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <input type="file" class="form-control rounded-3 fs-5" multiple
                                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.rar,.zip,.7z"
                                            @change="handleDocumentsChange" />
                                        <div v-if="errors.attached_documents" class="text-mydanger mt-2">{{ errors.attached_documents }}</div>
                                        <div v-if="documentItemError" class="text-mydanger mt-2">{{ documentItemError }}</div>
                                        <div v-if="form.attached_documents.length" class="mt-5">
                                            <div v-for="(document, index) in form.attached_documents" :key="`${document.name}-${index}`"
                                                class="d-flex align-items-center justify-content-between gap-3 border border-gray-300 rounded-3 px-4 py-3 mb-3">
                                                <div class="d-flex align-items-center gap-4 min-w-0">
                                                    <i class="ri-file-fill fs-1 text-myprimary"></i>
                                                    <div class="min-w-0">
                                                        <p class="mb-1 text-dark fw-bolder fs-6 text-truncate-1">{{ document.name }}</p>
                                                        <p class="mb-0 fs-7 text-gray-600">{{ formatFileSize(document.size) }}</p>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-icon btn-mydanger-tinted rounded-3" @click="removeDocument(index)">
                                                    <i class="ri-delete-bin-fill fs-3"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-4 border border-gray-300 mt-6">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="required fw-bolder mb-0">Metode Pengiriman</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div v-for="(item, index) in form.submission_method" :key="`sub-${index}`" class="d-flex gap-3 mb-4">
                                            <input type="text" required class="form-control rounded-3 fs-5" v-model="form.submission_method[index]" placeholder="Masukkan metode pengiriman..." />
                                            <button type="button" class="btn btn-icon btn-mydanger-tinted rounded-3" @click="removeListItem('submission_method', index)" :disabled="form.submission_method.length === 1">
                                                <i class="ri-delete-bin-fill fs-3"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-mytertiary-tinted w-100 rounded-3 fw-bolder fs-6" @click="addListItem('submission_method')">Tambah Poin</button>
                                        <div v-if="errors.submission_method" class="text-mydanger mt-2">{{ errors.submission_method }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-7">
                            <Link href="/admin/manuscript-categories" type="button" class="btn btn-sm btn-mytertiary-tinted rounded-3 fw-bolder fs-5 me-3">Batal</Link>
                            <button type="submit" id="submit_button" class="btn btn-sm btn-myprimary-filled rounded-3 fw-bolder fs-5">
                                <span class="indicator-label">Tambah Kategori</span>
                                <span class="indicator-progress">Mohon Tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
    import { reactive, ref, onMounted } from 'vue';
    import Swal from 'sweetalert2';
    import Dropzone from 'dropzone';

    export default {
        layout: LayoutAdmin,

        components: {
            Head,
            Link,
        },

        props: {
            setting: Object,
            errors: Object,
        },

        setup() {
            const imageItemError = ref('');
            const documentItemError = ref('');

            const form = reactive({
                title: '',
                description: '',
                image: null,
                requirements: [''],
                attachments: [''],
                attached_documents: [],
                submission_method: [''],
            });

            onMounted(() => {
                new Dropzone('#category-dropzone', {
                    url: '/',
                    paramName: 'image',
                    maxFiles: 1,
                    maxFilesize: 10,
                    acceptedFiles: 'image/jpeg,image/png,image/jpg,image/webp',
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    dictRemoveFile: 'Hapus',
                    init: function () {
                        this.on('addedfile', function (file) {
                            imageItemError.value = '';
                            form.image = file;
                        });

                        this.on('removedfile', function () {
                            form.image = null;
                        });

                        this.on('error', function (_file, message) {
                            imageItemError.value = typeof message === 'string' ? message : 'Gagal menambahkan gambar.';
                        });
                    },
                });
            });

            const addListItem = (key) => {
                form[key].push('');
            };

            const removeListItem = (key, index) => {
                if (form[key].length === 1) {
                    form[key][0] = '';
                    return;
                }

                form[key].splice(index, 1);
            };

            const handleDocumentsChange = (event) => {
                documentItemError.value = '';
                form.attached_documents = Array.from(event.target.files || []);
            };

            const removeDocument = (index) => {
                form.attached_documents.splice(index, 1);
            };

            const formatFileSize = (size) => {
                if (!size) return '0 B';
                const units = ['B', 'KB', 'MB', 'GB'];
                let value = size;
                let unitIndex = 0;
                while (value >= 1024 && unitIndex < units.length - 1) {
                    value /= 1024;
                    unitIndex++;
                }
                return `${value.toFixed(unitIndex === 0 ? 0 : 1)} ${units[unitIndex]}`;
            };

            const submit = () => {
                const submitBtn = document.querySelector('#submit_button');
                if (submitBtn) {
                    submitBtn.setAttribute('data-kt-indicator', 'on');
                    submitBtn.setAttribute('disabled', true);
                }

                const payload = new FormData();
                payload.append('title', form.title);
                payload.append('description', form.description);
                if (form.image && (form.image instanceof File || form.image instanceof Blob)) {
                    payload.append('image', form.image);
                }
                form.requirements.forEach((item, index) => payload.append(`requirements[${index}]`, item));
                form.attachments.forEach((item, index) => payload.append(`attachments[${index}]`, item));
                form.submission_method.forEach((item, index) => payload.append(`submission_method[${index}]`, item));
                form.attached_documents.forEach((item, index) => payload.append(`attached_documents[${index}]`, item));

                const cleanup = () => {
                    if (submitBtn) {
                        submitBtn.removeAttribute('data-kt-indicator');
                        submitBtn.removeAttribute('disabled');
                    }
                };

                router.post('/admin/manuscript-categories', payload, {
                    onSuccess: () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data Kategori Naskah Berhasil Disimpan!',
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
                imageItemError,
                documentItemError,
                addListItem,
                removeListItem,
                handleDocumentsChange,
                removeDocument,
                formatFileSize,
                submit,
            };
        }
    }
</script>

<style>

</style>
