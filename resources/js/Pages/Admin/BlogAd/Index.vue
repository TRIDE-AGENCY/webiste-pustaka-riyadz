<template>

    <Head>
        <title>Iklan Blog − Admin {{ setting.site_title }}</title>
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
                            <li class="breadcrumb-item pe-3 text-muted">Iklan Blog</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Iklan Blog</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl px-0">
                    <div class="card rounded-4 border border-gray-300 overflow-hidden">
                        <div class="d-flex flex-grow border-0 p-6 gap-4 flex-column flex-md-row">
                            <div class="flex-grow-1">
                                <form @submit.prevent="handleSearch"
                                    class="d-flex align-items-center position-relative my-1w-100 w-md-300px">
                                    <i class="ri-search-line position-absolute ms-5 fs-3"></i>
                                    <input type="text" class="form-control form-control-solid rounded-3 ps-13 fs-5"
                                        placeholder="Cari sesuatu disini..." v-model="search" />
                                </form>
                            </div>
                            <div class="d-flex gap-4">
                                <button type="button" @click="openCreateDrawer"
                                    class="w-100 w-md-auto btn btn-sm btn-myprimary-filled rounded-3 ps-5 fs-5 d-flex gap-1 align-items-center justify-content-center">
                                    <i class="fs-2 ri-add-line"></i>
                                    <span class="fw-bolder">Iklan Blog</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="text-center border-top border-gray-300 py-10 px-6" v-if="blog_ads.data.length === 0">
                                <img src="/assets/media/illustrations/empty.png"
                                    alt="Tidak ada data" class="mh-225px img-fluid mb-10">
                                <h2 class="text-dark mb-3 fw-bolder">Iklan Blog Tidak Ditemukan</h2>
                                <p class="text-gray-600 fs-4 mb-0">Belum ada iklan blog atau pencarian tidak sesuai.</p>
                            </div>
                            <div class="table-responsive" v-else>
                                <table
                                    class="table table-hover align-middle table-row-bordered fs-5 gy-5 border-bottom border-gray-300 mb-0">
                                    <thead>
                                        <tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-20px ps-6 pe-5 bg-secondary" style="letter-spacing: 0.04em;">#</th>
                                            <th class="bg-secondary min-w-325px" style="letter-spacing: 0.04em;">Iklan</th>
                                            <!-- <th class="bg-secondary min-w-325px" style="letter-spacing: 0.04em;">Keterangan</th> -->
                                            <th class="bg-secondary min-w-150px" style="letter-spacing: 0.04em;">Dibuat</th>
                                            <th class="bg-secondary pe-6 min-w-125px" style="letter-spacing: 0.04em;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="(blogAd, index) in blog_ads.data" :key="blogAd.id">
                                            <td class="ps-6">
                                                {{ ++index + (blog_ads.current_page - 1) * blog_ads.per_page }}
                                            </td>
                                            <td class="d-flex align-items-center gap-4">
                                                <div class="ratio ratio-4x3 w-55px w-md-65px flex-shrink-0">
                                                    <img class="h-100 rounded-3 img-fluid object-fit-cover"
                                                        :src="blogAd.image ? `/storage/${blogAd.image}` : '/assets/media/illustrations/blog-placeholder.png'"
                                                        :alt="blogAd.description || 'Gambar Iklan Blog'" />
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="mb-1 text-dark fs-5 text-truncate-2">
                                                        {{ blogAd.description }}
                                                    </p>
                                                    <a v-if="blogAd.link" :href="blogAd.link" target="_blank"
                                                        class="d-block text-myprimary fs-7 fw-semibold text-truncate-1 mw-300px">
                                                        {{ blogAd.link }}
                                                    </a>
                                                    <span v-else class="d-block text-gray-500 fs-7 fw-semibold">Tanpa link</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bolder fs-5 mb-1">{{ formatDate(blogAd.created_at) }}</span>
                                                    <span class="fs-7">{{ formatTime(blogAd.created_at) }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-6">
                                                <button type="button" @click="openEditDrawer(blogAd)"
                                                    class="btn btn-sm btn-icon btn-myprimary-tinted rounded-3 me-2">
                                                    <i class="ri-edit-2-fill fs-3"></i>
                                                </button>
                                                <button @click.prevent="destroy(blogAd.id)"
                                                    class="btn btn-sm btn-icon btn-mydanger-tinted rounded-3">
                                                    <i class="ri-delete-bin-fill fs-3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <Pagination v-if="blog_ads.data != 0"
                                :links="blog_ads.links" align="end" class="py-5 px-6" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Transition name="fade">
            <div v-show="drawerOpen" class="drawer-backdrop" @click="closeDrawer"></div>
        </Transition>

        <Transition name="slide-drawer">
            <div v-show="drawerOpen" class="blog-ad-drawer bg-light shadow-sm">
                <div
                    class="d-flex align-items-center ps-6 pe-3 min-h-60px min-h-lg-70px gap-6 justify-content-between border-bottom border-gray-300">
                    <h2 class="mb-0 fw-bolder">{{ isEditMode ? 'Edit Iklan Blog' : 'Tambah Iklan Blog' }}</h2>
                    <div @click="closeDrawer" class="btn btn-sm btn-icon btn-mytertiary-ghost rounded-pill">
                        <i class="bi bi-x-lg fs-3"></i>
                    </div>
                </div>

                <form @submit.prevent="submit" class="d-flex flex-column h-100 overflow-auto">
                    <div class="flex-grow-1 p-6">
                        <div class="card rounded-4 border border-gray-300 mb-6">
                            <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300"
                                style="min-height: unset;">
                                <h3 class="mb-0 fw-bolder required">Gambar Iklan</h3>
                            </div>
                            <div class="card-body p-6">
                                <div id="blog-ad-dropzone"
                                    class="dropzone border-dashed border-myprimary rounded-3 p-6 text-center">
                                    <div class="dz-message needsclick flex-column text-center gap-5 p-5">
                                        <i class="ri-image-add-line text-myprimary fs-3x"></i>
                                        <div>
                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-2">Jatuhkan file di sini / klik untuk mengunggah.</h3>
                                            <span class="fs-7 fw-semibold text-gray-600">Maks. 10 MB • Rasio 4:3 / 1:1</span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="errors.image" class="text-mydanger mt-2">
                                    {{ errors.image }}
                                </div>
                                <div v-if="imageItemError" class="text-mydanger mt-2">
                                    {{ imageItemError }}
                                </div>
                            </div>
                        </div>

                        <div class="card rounded-4 border border-gray-300">
                            <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300"
                                style="min-height: unset;">
                                <h3 class="mb-0 fw-bolder required">Keterangan</h3>
                            </div>
                            <div class="card-body p-6">
                                <div class="fv-row">
                                    <textarea class="form-control rounded-3 fs-5" rows="5" v-model="form.description"
                                        required placeholder="Masukkan keterangan gambar disini..."
                                        :class="{ 'is-invalid': errors.description }"></textarea>
                                    <div v-if="errors.description" class="text-mydanger mt-2">
                                        {{ errors.description }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card rounded-4 border border-gray-300 mt-6">
                            <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300"
                                style="min-height: unset;">
                                <h3 class="mb-0 fw-bolder">Link Tujuan</h3>
                            </div>
                            <div class="card-body p-6">
                                <div class="fv-row">
                                    <input type="url" class="form-control rounded-3 fs-5" v-model="form.link"
                                        placeholder="https://contoh.com"
                                        :class="{ 'is-invalid': errors.link }">
                                    <div v-if="errors.link" class="text-mydanger mt-2">
                                        {{ errors.link }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end p-6 pt-1 gap-3">
                        <button type="button" @click="closeDrawer"
                            class="btn btn-sm btn-mytertiary-tinted rounded-3 fw-bolder fs-5">
                            Batal
                        </button>
                        <button type="submit" id="submit_button"
                            class="btn btn-sm btn-myprimary-filled rounded-3 fw-bolder fs-5">
                            <span class="indicator-label">
                                {{ isEditMode ? 'Edit Iklan Blog' : 'Tambah Iklan Blog' }}
                            </span>
                            <span class="indicator-progress">
                                Mohon Tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </Transition>
    </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import Pagination from '../../../Components/Pagination.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, reactive, onMounted, nextTick, watch } from 'vue';
import Swal from 'sweetalert2';
import Dropzone from 'dropzone';

export default {
    layout: LayoutAdmin,

    components: {
        Head,
        Link,
        Pagination
    },

    props: {
        setting: Object,
        errors: Object,
        blog_ads: Object,
    },

    setup(props) {
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));
        const drawerOpen = ref(false);
        const isEditMode = ref(false);
        const editingId = ref(null);
        const imageItemError = ref('');
        const dropzoneInstance = ref(null);

        const form = reactive({
            image: null,
            description: '',
            link: '',
            image_url: null,
            image_name: null,
            image_size: null,
        });

        const resetForm = () => {
            form.image = null;
            form.description = '';
            form.link = '';
            form.image_url = null;
            form.image_name = null;
            form.image_size = null;
            editingId.value = null;
            isEditMode.value = false;
            imageItemError.value = '';

            clearDropzonePreview();
        };

        const initDropzone = () => {
            if (dropzoneInstance.value || !document.querySelector('#blog-ad-dropzone')) {
                return;
            }

            dropzoneInstance.value = new Dropzone('#blog-ad-dropzone', {
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

                        if (file.isExisting) {
                            form.image = null;
                            return;
                        }

                        form.image = file;
                    });

                    this.on('removedfile', function (file) {
                        if (file.isExisting) {
                            form.image = null;
                            form.image_url = null;
                            form.image_name = null;
                            form.image_size = null;
                            refreshDropzoneEmptyState();
                            return;
                        }

                        form.image = null;
                        refreshDropzoneEmptyState();
                    });

                    this.on('maxfilesexceeded', function (file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });

                    this.on('error', function (_file, message) {
                        imageItemError.value = typeof message === 'string' ? message : 'Gagal menambahkan gambar.';
                    });
                },
            });
        };

        const populateExistingImage = () => {
            if (!dropzoneInstance.value || !form.image_url) {
                clearDropzonePreview();
                return;
            }

            clearDropzonePreview();

            const mockFile = {
                name: form.image_name ?? 'Gambar Iklan Blog',
                size: form.image_size ?? 12345,
                isExisting: true,
            };

            dropzoneInstance.value.files = [mockFile];
            dropzoneInstance.value.displayExistingFile(mockFile, form.image_url);

            if (mockFile.previewElement) {
                mockFile.previewElement.classList.add('dz-success', 'dz-complete');
            }
        };

        const clearDropzonePreview = () => {
            if (!dropzoneInstance.value) {
                return;
            }

            dropzoneInstance.value.files = [];
            dropzoneInstance.value.element
                .querySelectorAll('.dz-preview')
                .forEach((preview) => preview.remove());
            dropzoneInstance.value.element.classList.remove('dz-started');
        };

        const refreshDropzoneEmptyState = () => {
            if (!dropzoneInstance.value) {
                return;
            }

            requestAnimationFrame(() => {
                const hasPreview = dropzoneInstance.value.element.querySelector('.dz-preview');

                if (!hasPreview) {
                    dropzoneInstance.value.files = [];
                    dropzoneInstance.value.element.classList.remove('dz-started');
                }
            });
        };

        watch(drawerOpen, async (isOpen) => {
            if (isOpen) {
                await nextTick();
                initDropzone();
                populateExistingImage();
                document.body.classList.add('overflow-hidden');
                document.documentElement.classList.add('overflow-hidden');
                return;
            }

            document.body.classList.remove('overflow-hidden');
            document.documentElement.classList.remove('overflow-hidden');
        });

        onMounted(() => {
            if (props.errors && Object.keys(props.errors).length > 0) {
                drawerOpen.value = true;
                nextTick(() => {
                    initDropzone();
                    populateExistingImage();
                });
            }
        });

        const handleSearch = () => {
            router.get('/admin/blog-ads', {
                q: search.value,
            });
        };

        const openCreateDrawer = () => {
            resetForm();
            drawerOpen.value = true;
        };

        const openEditDrawer = (blogAd) => {
            resetForm();
            isEditMode.value = true;
            editingId.value = blogAd.id;
            form.description = blogAd.description;
            form.link = blogAd.link ?? '';
            form.image_url = blogAd.image_url;
            form.image_name = blogAd.image_name ?? 'Gambar Iklan Blog';
            form.image_size = blogAd.image_size ?? 12345;
            drawerOpen.value = true;

            nextTick(() => {
                initDropzone();
                populateExistingImage();
            });
        };

        const closeDrawer = () => {
            drawerOpen.value = false;
            resetForm();
        };

        const formatDate = (dateString) => {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        };

        const formatTime = (dateString) => {
            return new Date(dateString).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
        };

        const submit = () => {
            const submitBtn = document.querySelector('#submit_button');
            if (submitBtn) {
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.setAttribute('disabled', true);
            }

            const payload = new FormData();
            payload.append('description', form.description);
            payload.append('link', form.link ?? '');

            if (form.image && (form.image instanceof File || form.image instanceof Blob)) {
                payload.append('image', form.image);
            }

            const cleanup = () => {
                if (submitBtn) {
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.removeAttribute('disabled');
                }
            };

            const requestUrl = isEditMode.value
                ? `/admin/blog-ads/${editingId.value}`
                : '/admin/blog-ads';

            if (isEditMode.value) {
                payload.append('_method', 'PUT');
            }

            router.post(requestUrl, payload, {
                onSuccess: () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: isEditMode.value
                            ? 'Data Iklan Blog Berhasil Diperbarui!'
                            : 'Data Iklan Blog Berhasil Disimpan!',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal-custom-icon',
                        }
                    });
                    closeDrawer();
                },
                onFinish: cleanup
            });
        };

        const destroy = (id) => {
            Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak akan dapat mengembalikan ini!',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-custom-icon',
                    confirmButton: 'btn btn-sm btn-myprimary-filled rounded-3 fw-bolder',
                    cancelButton: 'btn btn-sm btn-mydanger-tinted rounded-3 fw-bolder'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    router.delete(`/admin/blog-ads/${id}`);
                    Swal.fire({
                        icon: 'success',
                        title: 'Dihapus!',
                        text: 'Data Iklan Blog Berhasil Dihapus!',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal-custom-icon',
                        },
                    });
                }
            });
        };

        return {
            search,
            drawerOpen,
            isEditMode,
            form,
            imageItemError,
            handleSearch,
            openCreateDrawer,
            openEditDrawer,
            closeDrawer,
            formatDate,
            formatTime,
            submit,
            destroy,
        };
    }
}
</script>

<style scoped>
.drawer-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(11, 18, 32, 0.35);
    backdrop-filter: blur(3px);
    z-index: 1045;
}

.blog-ad-drawer {
    position: fixed;
    top: 0;
    right: 0;
    width: min(100%, 560px);
    height: 100vh;
    z-index: 1050;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-drawer-enter-active,
.slide-drawer-leave-active {
    transition: transform 0.28s ease, opacity 0.28s ease;
}

.slide-drawer-enter-from,
.slide-drawer-leave-to {
    transform: translateX(100%);
    opacity: 0.9;
}

@media (max-width: 767.98px) {
    .blog-ad-drawer {
        width: 100%;
    }
}
</style>
