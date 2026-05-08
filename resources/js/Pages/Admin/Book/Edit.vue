<template>

    <Head>
        <title>Edit Buku − Admin {{ setting.site_title }}</title>
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
                                <Link href="/admin/books" class="btn-link-myprimary fw-bolder pe-3">Daftar Buku</Link>
                            </li>
                            <li class="breadcrumb-item pe-3 text-muted">Edit</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Edit Buku</h1>
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
                                        <h3 class="mb-0 fw-bolder">Informasi Buku</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div class="mb-5 fv-row">
                                            <label class="required form-label fs-6">Judul</label>
                                            <textarea class="form-control rounded-3 fs-5" rows="3"
                                                required placeholder="Masukkan judul disini..."
                                                v-model="form.title" :class="{ 'is-invalid': errors.title }">
                                            </textarea>
                                            <div v-if="errors.title" class="text-mydanger mt-2">
                                                {{ errors.title }}
                                            </div>
                                        </div>
                                        <div class="mb-5 row g-5">
                                            <div class="col-md-6 fv-row">
                                                <label class="required form-label fs-6">Penulis</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.author" required placeholder="Masukkan penulis disini..."
                                                    :class="{ 'is-invalid': errors.author }" />
                                                <div v-if="errors.author" class="text-mydanger mt-2">
                                                    {{ errors.author }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 fv-row">
                                                <label class="required form-label fs-6">Penerbit</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.publisher" required placeholder="Masukkan penerbit disini..."
                                                    :class="{ 'is-invalid': errors.publisher }" />
                                                <div v-if="errors.publisher" class="text-mydanger mt-2">
                                                    {{ errors.publisher }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-5 row g-5">
                                            <div class="col-md-6 fv-row">
                                                <label class="form-label fs-6">Kategori</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.category" placeholder="Masukkan kategori disini..."
                                                    :class="{ 'is-invalid': errors.category }" />
                                                <div v-if="errors.category" class="text-mydanger mt-2">
                                                    {{ errors.category }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 fv-row">
                                                <label class="form-label fs-6">Subjek</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.subject" placeholder="Masukkan subjek disini..."
                                                    :class="{ 'is-invalid': errors.subject }" />
                                                <div v-if="errors.subject" class="text-mydanger mt-2">
                                                    {{ errors.subject }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-5 row g-5">
                                            <div class="col-md-6 fv-row">
                                                <label class="form-label fs-6">ISBN</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.isbn" placeholder="Masukkan ISBN disini..."
                                                    :class="{ 'is-invalid': errors.isbn }" />
                                                <div v-if="errors.isbn" class="text-mydanger mt-2">
                                                    {{ errors.isbn }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 fv-row">
                                                <label class="required form-label fs-6">Tahun</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.year" required placeholder="Contoh: 2026"
                                                    :class="{ 'is-invalid': errors.year }" />
                                                <div v-if="errors.year" class="text-mydanger mt-2">
                                                    {{ errors.year }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-5">
                                            <div class="col-md-6 fv-row">
                                                <label class="required form-label fs-6">Dimensi</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.dimensions" required placeholder="Contoh: 14 x 20 cm"
                                                    :class="{ 'is-invalid': errors.dimensions }" />
                                                <div v-if="errors.dimensions" class="text-mydanger mt-2">
                                                    {{ errors.dimensions }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 fv-row">
                                                <label class="required form-label fs-6">Halaman</label>
                                                <input type="text" class="form-control rounded-3 fs-5"
                                                    v-model="form.pages" required placeholder="Contoh: xii + 200"
                                                    :class="{ 'is-invalid': errors.pages }" />
                                                <div v-if="errors.pages" class="text-mydanger mt-2">
                                                    {{ errors.pages }}
                                                </div>
                                            </div>
                                            <div class="col-md-12 fv-row">
                                                <label class="form-label fs-6">Harga</label>
                                                <div class="input-group">
                                                    <span class="input-group-text rounded-3 rounded-end-0" id="basic-addon2">Rp</span>
                                                    <input
                                                        type="number" min="0"
                                                        class="form-control fs-5 rounded-3 rounded-start-0"
                                                        v-model="form.price"
                                                        placeholder="Masukkan harga disini..."
                                                        :class="{ 'is-invalid': errors.price }"
                                                    />
                                                </div>
                                                <div v-if="errors.price" class="text-mydanger mt-2">
                                                    {{ errors.price }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-7">
                                <div class="card rounded-4 border border-gray-300 mb-6">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="required fw-bolder mb-0">Deskripsi Buku</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <Editor
                                            :api-key="api_tinymce_key"
                                            v-model="form.description"
                                            :init="editorInit"
                                        />
                                        <div v-if="errors.description" class="text-mydanger mt-2">
                                            {{ errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-4 border border-gray-300">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="required fw-bolder mb-0">Galeri Buku</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div id="book-dropzone" class="dropzone border-dashed border-myprimary rounded-3 p-5 text-center">
                                            <div class="dz-message needsclick flex-column text-center gap-5 p-5">
                                                <i class="ri-image-add-line text-myprimary fs-3x"></i>
                                                <div>
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-2">Jatuhkan file di sini / klik untuk mengunggah.</h3>
                                                    <span class="fs-7 fw-semibold text-gray-600">Maks. 10 MB / gambar</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="errors.images" class="text-mydanger mt-2">
                                            {{ errors.images }}
                                        </div>
                                        <div v-if="imageItemError" class="text-mydanger mt-2">
                                            {{ imageItemError }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-7">
                            <Link href="/admin/books" type="button" class="btn btn-sm btn-mytertiary-tinted rounded-3 fw-bolder fs-5 me-3">Batal</Link>
                            <button type="submit" id="submit_button"
                                class="btn btn-sm btn-myprimary-filled rounded-3 fw-bolder fs-5">
                                <span class="indicator-label">
                                    Edit Buku
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
    import { reactive, ref, onMounted } from 'vue';
    import Swal from 'sweetalert2';
    import Dropzone from 'dropzone';
    import Editor from '@tinymce/tinymce-vue';

    export default {
        layout: LayoutAdmin,

        components: {
            Head,
            Link,
            Editor,
        },

        props: {
            setting: Object,
            errors: Object,
            book: Object,
            api_tinymce_key: String,
        },

        setup(props) {
            const form = reactive({
                title: props.book.title,
                publisher: props.book.publisher,
                author: props.book.author,
                category: props.book.category ?? '',
                subject: props.book.subject ?? '',
                isbn: props.book.isbn ?? '',
                dimensions: props.book.dimensions,
                pages: props.book.pages,
                year: props.book.year,
                price: props.book.price ?? '',
                description: props.book.description,
                images: [],
                removed_images: [],
            });

            const imageItemError = ref('');

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

            onMounted(() => {
                new Dropzone('#book-dropzone', {
                    url: '/',
                    paramName: 'images',
                    uploadMultiple: true,
                    maxFiles: 10,
                    maxFilesize: 10,
                    acceptedFiles: 'image/jpeg,image/png,image/jpg,image/webp',
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    dictRemoveFile: 'Hapus',
                    init: function () {
                        this.on('addedfile', function (file) {
                            imageItemError.value = '';

                            if (file.isExisting) {
                                return;
                            }

                            form.images.push(file);
                        });

                        this.on('removedfile', function (file) {
                            if (file.isExisting) {
                                if (!form.removed_images.includes(file.existingPath)) {
                                    form.removed_images.push(file.existingPath);
                                }
                                return;
                            }

                            form.images = form.images.filter((item) => item !== file);
                        });

                        this.on('error', function (_file, message) {
                            imageItemError.value = typeof message === 'string' ? message : 'Gagal menambahkan gambar.';
                        });

                        props.book.existing_images.forEach((image) => {
                            const mockFile = {
                                name: image.name,
                                size: image.size,
                                isExisting: true,
                                existingPath: image.path,
                            };

                            this.emit('addedfile', mockFile);
                            this.emit('thumbnail', mockFile, image.url);
                            this.emit('complete', mockFile);

                            if (mockFile.previewElement) {
                                mockFile.previewElement.classList.add('dz-success', 'dz-complete');
                            }
                        });
                    },
                });
            });

            const submit = () => {
                const submitBtn = document.querySelector('#submit_button');
                if (submitBtn) {
                    submitBtn.setAttribute('data-kt-indicator', 'on');
                    submitBtn.setAttribute('disabled', true);
                }

                const payload = new FormData();
                payload.append('title', form.title);
                payload.append('publisher', form.publisher);
                payload.append('author', form.author);
                payload.append('category', form.category);
                payload.append('subject', form.subject);
                payload.append('isbn', form.isbn);
                payload.append('dimensions', form.dimensions);
                payload.append('pages', form.pages);
                payload.append('year', form.year);
                payload.append('price', form.price);
                payload.append('description', form.description);

                form.images.forEach((image, index) => {
                    if (image instanceof File || image instanceof Blob) {
                        payload.append(`images[${index}]`, image);
                    }
                });

                form.removed_images.forEach((image, index) => {
                    payload.append(`removed_images[${index}]`, image);
                });

                const cleanup = () => {
                    if (submitBtn) {
                        submitBtn.removeAttribute('data-kt-indicator');
                        submitBtn.removeAttribute('disabled');
                    }
                };

                payload.append('_method', 'PUT');
                router.post(`/admin/books/${props.book.id}`, payload, {
                    onSuccess: () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data Buku Berhasil Diperbarui!',
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
                editorInit,
                submit,
            };
        }
    }
</script>

<style>

</style>
