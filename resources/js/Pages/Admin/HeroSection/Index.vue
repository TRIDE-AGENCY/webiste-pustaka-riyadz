<template>

    <Head>
        <title>Hero Section − Admin {{ setting.site_title }}</title>
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
                            <li class="breadcrumb-item pe-3 text-muted">Hero Section</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Hero Section</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl px-0">
                    <form @submit.prevent="submit">
                        <div class="card rounded-4 border border-gray-300">
                            <div class="row align-items-start m-0">
                                <div class="col-12 col-md-4 col-xl-3 p-0">
                                    <div
                                        class="card-header p-6 d-flex flex-column m-0 border-0"
                                        style="min-height: unset"
                                    >
                                        <h3 class="mb-0 fw-bolder">Konten Hero</h3>
                                        <p
                                            class="fs-5 d-none d-md-block text-gray-600 mt-3 mb-0 fw-normal"
                                        >
                                            Mengatur heading dan subheading
                                            pada landing page
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="d-md-none border-bottom border-gray-300"
                                ></div>
                                <div
                                    class="col-12 col-md-8 col-xl-9 card-body p-6"
                                >
                                    <div class="mb-5 fv-row">
                                        <label class="required form-label fs-6"
                                            >Heading</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control rounded-3 fs-5"
                                            v-model="form.heading"
                                            required
                                            placeholder="Masukkan heading disini..."
                                            :class="{
                                                'is-invalid': errors.heading,
                                            }"
                                        />
                                        <div
                                            v-if="errors.heading"
                                            class="text-mydanger mt-2"
                                        >
                                            {{ errors.heading }}
                                        </div>
                                    </div>
                                    <div class="fv-row">
                                        <label class="required form-label fs-6"
                                            >Subheading</label
                                        >
                                        <textarea
                                            class="form-control rounded-3 fs-5"
                                            data-kt-autosize="true"
                                            rows="4"
                                            required
                                            placeholder="Masukkan subheading disini..."
                                            v-model="form.subheading"
                                            :class="{
                                                'is-invalid': errors.subheading,
                                            }"
                                        >
                                        </textarea>
                                        <div
                                            v-if="errors.subheading"
                                            class="text-mydanger mt-2"
                                        >
                                            {{ errors.subheading }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card rounded-4 border border-gray-300 mt-6">
                            <div class="row align-items-start m-0">
                                <div class="col-12 col-md-4 col-xl-3 p-0">
                                    <div
                                        class="card-header p-6 d-flex flex-column m-0 border-0"
                                        style="min-height: unset"
                                    >
                                        <h3 class="mb-0 fw-bolder">Media Hero</h3>
                                        <p
                                            class="fs-5 d-none d-md-block text-gray-600 mt-3 mb-0 fw-normal"
                                        >
                                            Mengatur gambar utama yang tampil
                                            di hero landing page
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="d-md-none border-bottom border-gray-300"
                                ></div>
                                <div
                                    class="col-12 col-md-8 col-xl-9 card-body p-6"
                                >
                                    <div class="fv-row">
                                        <label class="required form-label fs-6"
                                            >Gambar</label
                                        >
                                        <div
                                            id="hero-dropzone"
                                            :key="dropzoneKey"
                                            class="dropzone border-dashed border-myprimary rounded-3 p-5 text-center"
                                        >
                                            <div
                                                class="dz-message needsclick flex-column text-center gap-5 p-5"
                                            >
                                                <i
                                                    class="ri-image-add-line text-myprimary fs-3x"
                                                ></i>
                                                <div>
                                                    <h3
                                                        class="fs-5 fw-bolder text-gray-900 mb-2"
                                                    >
                                                        Jatuhkan file di sini /
                                                        klik untuk mengunggah.
                                                    </h3>
                                                    <span
                                                        class="fs-7 fw-semibold text-gray-500"
                                                        >Maksimal 10 MB</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-if="errors.image"
                                            class="text-mydanger mt-2"
                                        >
                                            {{ errors.image }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-7">
                            <button
                                type="submit"
                                id="submit_button"
                                class="btn btn-sm btn-myprimary-filled rounded-3 fw-bolder fs-5"
                            >
                                <span class="indicator-label">
                                    Simpan Perubahan
                                </span>
                                <span class="indicator-progress">
                                    Mohon Tunggu...
                                    <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"
                                    ></span>
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
    import { Head, Link, router } from "@inertiajs/vue3";
    import { reactive, ref, onMounted, nextTick } from "vue";
    import Dropzone from "dropzone";
    import Swal from "sweetalert2";

    export default {
        layout: LayoutAdmin,

        components: {
            Head,
            Link,
        },

        props: {
            errors: Object,
            setting: Object,
            hero_section: {
                type: Object,
                default: () => ({}),
            },
        },

        setup(props) {
            const dropzoneHero = ref(null);
            const dropzoneKey = ref(Date.now());
            const originalImage = ref(props.hero_section?.image ?? null);
            const originalImageUrl = ref(props.hero_section?.image_url ?? null);
            const imageFile = ref(null);

            const form = reactive({
                heading: props.hero_section?.heading ?? props.setting?.site_title ?? '',
                subheading: props.hero_section?.subheading ?? props.setting?.meta_description ?? '',
                image: props.hero_section?.image ?? '',
            });

            onMounted(() => {
                nextTick(() => {
                    dropzoneHero.value = new Dropzone("#hero-dropzone", {
                        url: "/",
                        maxFiles: 1,
                        maxFilesize: 10,
                        acceptedFiles: "image/jpeg,image/png,image/jpg,image/webp",
                        autoProcessQueue: false,
                        addRemoveLinks: true,
                        dictRemoveFile: "Hapus",
                        init: function () {
                            if (originalImage.value) {
                                const mockFile = {
                                    name: originalImage.value.split("/").pop(),
                                    size: props.hero_section?.image_size ?? 12345,
                                };

                                let imageUrl = originalImageUrl.value ?? originalImage.value;
                                if (!imageUrl.startsWith("/storage/") && !imageUrl.startsWith("http")) {
                                    imageUrl = `/storage/${imageUrl}`;
                                }

                                this.emit("addedfile", mockFile);
                                this.emit("thumbnail", mockFile, imageUrl);
                                this.emit("complete", mockFile);
                                mockFile.previewElement.classList.add("dz-success", "dz-complete");
                            }

                            this.on("addedfile", (file) => {
                                imageFile.value = file;
                                if (this.files.length > 1) {
                                    this.removeFile(this.files[0]);
                                }
                            });

                            this.on("removedfile", () => {
                                imageFile.value = null;
                            });
                        },
                    });
                });
            });

            const submit = () => {
                const submitBtn = document.querySelector("#submit_button");
                if (submitBtn) {
                    submitBtn.setAttribute("data-kt-indicator", "on");
                    submitBtn.setAttribute("disabled", true);
                }

                const payload = new FormData();
                payload.append("_method", "PUT");
                payload.append("heading", form.heading);
                payload.append("subheading", form.subheading);

                if (imageFile.value instanceof File) {
                    payload.append("image", imageFile.value);
                }

                const cleanup = () => {
                    if (submitBtn) {
                        submitBtn.removeAttribute("data-kt-indicator");
                        submitBtn.removeAttribute("disabled");
                    }
                };

                router.post(`/admin/hero-sections`, payload, {
                    onSuccess: () => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Hero Section Berhasil Diperbarui!",
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            customClass: {
                                popup: "swal-custom-icon",
                            },
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    onFinish: cleanup,
                });
            };

            return {
                form,
                submit,
                dropzoneKey,
            };
        },
    };
</script>

<style>

</style>
