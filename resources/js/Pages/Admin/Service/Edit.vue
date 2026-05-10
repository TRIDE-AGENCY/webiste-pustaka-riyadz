<template>
    <Head>
        <title>Edit Layanan − Admin {{ setting?.site_title || 'Panel' }}</title>
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
                                <Link href="/admin/services" class="btn-link-myprimary fw-bolder pe-3">Layanan</Link>
                            </li>
                            <li class="breadcrumb-item pe-3 text-muted">Edit</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Edit Layanan</h1>
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
                                            <label class="required form-label fs-6">Nama Layanan</label>
                                            <textarea class="form-control rounded-3 fs-5" rows="2" v-model="form.name" required placeholder="Contoh: Penerbitan Buku"></textarea>
                                        </div>
                                        <div class="fv-row">
                                            <label class="required form-label fs-6">Deskripsi Singkat</label>
                                            <textarea class="form-control rounded-3 fs-5" rows="3" v-model="form.short_description" required placeholder="Deskripsi singkat untuk preview..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-4 border border-gray-300 mt-6">
                                    <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="fw-bolder mb-0">Gambar Layanan</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        <div id="service-dropzone" class="dropzone border-dashed border-myprimary rounded-3 p-6 text-center">
                                            <div class="dz-message needsclick flex-column text-center gap-5 p-5">
                                                <i class="ri-image-add-line text-myprimary fs-3x"></i>
                                                <div>
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-2">Jatuhkan file di sini / klik untuk mengunggah.</h3>
                                                    <span class="fs-7 fw-semibold text-gray-600">Kosongkan jika tidak ingin mengubah gambar.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-7">
                                <div class="card rounded-4 border border-gray-300">
                                    <div class="card-header p-6 d-flex flex-column border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="mb-2 fw-bolder">Konten Dinamis</h3>
                                        <p class="mb-0 text-gray-600 fs-7">Tambahkan alur, keunggulan, atau catatan.</p>
                                    </div>
                                    <div class="card-body p-6">
                                        <div v-if="form.sections.length > 0" class="d-flex flex-column gap-6 mb-6">
                                            <div v-for="(sec, idx) in form.sections" :key="idx" class="d-flex gap-6 align-items-start pb-6 border-bottom border-gray-300">
                                                <div class="w-45px h-45px bg-myprimary-light text-myprimary fs-2 fw-bold rounded-pill d-flex flex-center flex-shrink-0">
                                                    {{ idx + 1 }}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-5 fv-row">
                                                        <label class="form-label required fs-6">Judul Konten</label>
                                                        <input required type="text" class="form-control rounded-3 fs-5" v-model="sec.title" placeholder="Contoh: Keunggulan Layanan" />
                                                    </div>
                                                    <div class="mb-5 fv-row">
                                                        <label class="form-label required fs-6">Tipe Konten</label>
                                                        <select required class="form-select rounded-3 fs-5" v-model="sec.type">
                                                            <option value="text">Teks Paragraf</option>
                                                            <option value="list">Daftar Poin</option>
                                                        </select>
                                                    </div>
                                                    <div class="fv-row">
                                                        <label class="form-label required fs-6">Isi Konten</label>
                                                        <textarea required class="form-control rounded-3 fs-5" rows="3" v-model="sec.content" 
                                                            :placeholder="sec.type === 'text' ? 'Ketik penjelasan...' : 'Item 1\nItem 2\n(Pisahkan dengan tombol Enter)'"></textarea>
                                                    </div>
                                                    <button type="button" class="mt-5 btn btn-sm btn-mydanger-tinted w-100 rounded-3 fw-bolder fs-6" @click="removeSection(idx)"
                                                        :disabled="form.sections.length === 1">Hapus Konten {{ idx + 1 }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-mytertiary-tinted w-100 rounded-3 fw-bolder fs-6" @click="addSection">Tambah Konten</button>
                                    </div>
                                </div>
                                
                                <div class="card rounded-4 border border-gray-300 mt-6">
                                    <div class="card-header p-6 d-flex justify-content-between align-items-center m-0 border-bottom border-gray-300" style="min-height: unset;">
                                        <h3 class="mb-0 fw-bolder">Pengaturan Harga</h3>
                                        <div class="form-check form-switch form-check-solid form-check-custom d-flex align-items-center gap-1">
                                            <input class="form-check-input w-30px h-20px cursor-pointer" type="checkbox" v-model="form.has_packages" />
                                            <label class="form-check-label fs-5 fw-bolder text-dark">
                                                Gunakan Paket
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body p-6">
                                        
                                        <template v-if="!form.has_packages">
                                            <div class="fv-row">
                                                <input type="text" class="form-control rounded-3 fs-5" v-model="form.starting_price" placeholder="Contoh: Mulai dari Rp1.199.000" />
                                            </div>
                                        </template>

                                        <template v-else>
                                            <div v-if="form.packages.length > 0" class="d-flex flex-column gap-6 mb-6">
                                                <div v-for="(pkg, idx) in form.packages" :key="idx" class="d-flex gap-6 align-items-start pb-6 border-bottom border-gray-300">
                                                    <div class="w-45px h-45px bg-myprimary-light text-myprimary fs-2 fw-bold rounded-pill d-flex flex-center flex-shrink-0">
                                                        {{ idx + 1 }}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="row g-5 mb-5">
                                                            <div class="col-md-6 fv-row">
                                                                <label class="form-label required fs-6">Nama Paket</label>
                                                                <input required type="text" class="form-control fs-5 rounded-3" v-model="pkg.name" placeholder="Contoh: Paket Basic" />
                                                            </div>
                                                            <div class="col-md-6 fv-row">
                                                                <label class="form-label required fs-6">Harga</label>
                                                                <input required type="text" class="form-control fs-5 rounded-3" v-model="pkg.price" placeholder="Contoh: Rp350.000" />
                                                            </div>
                                                        </div>
                                                        <div class="mb-5 fv-row">
                                                            <label class="form-label fs-6">Teks Rekomendasi</label>
                                                            <input type="text" class="form-control fs-5 rounded-3" v-model="pkg.recommendation" placeholder="Opsional: Untuk pemula..." />
                                                        </div>
                                                        <div class="fv-row">
                                                            <label class="form-label required fs-6">Daftar Fasilitas / Fitur</label>
                                                            <textarea required class="form-control fs-5 rounded-3" rows="3" v-model="pkg.features" placeholder="Fasilitas 1&#10;Fasilitas 2&#10;(Pisahkan dengan tombol Enter)"></textarea>
                                                        </div>
                                                        <button type="button" class="mt-5 btn btn-sm btn-mydanger-tinted w-100 rounded-3 fw-bolder fs-6" @click="removePackage(idx)"
                                                            :disabled="form.packages.length === 1">Hapus Paket {{ idx + 1 }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-mytertiary-tinted w-100 rounded-3 fw-bolder fs-6" @click="addPackage">Tambah Paket</button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-7">
                            <Link href="/admin/services" class="btn btn-sm btn-mytertiary-tinted rounded-3 fw-bolder fs-5">Batal</Link>
                            <button type="submit" id="submit_button" class="btn btn-sm btn-myprimary-filled rounded-3 fw-bolder fs-5">
                                <span class="indicator-label">Edit Layanan</span>
                                <span class="indicator-progress">Tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
import { ref, reactive, onMounted, nextTick, watch } from 'vue';
import Swal from 'sweetalert2';
import Dropzone from 'dropzone';

export default {
    layout: LayoutAdmin,
    components: { Head, Link },
    props: {
        setting: Object,
        service: Object,
        api_tinymce_key: String,
    },
    setup(props) {
        const dropzoneInstance = ref(null);

        // State Init: Ambil dari data props.service
        const form = reactive({
            name: props.service.name || '',
            short_description: props.service.short_description || '',
            description: props.service.description || '',
            starting_price: props.service.starting_price || '',
            has_packages: props.service.packages && props.service.packages.length > 0,
            packages: [],
            sections: [],
            image: null,
            _method: 'PUT' // Penting untuk mengirim file upload via PUT di Laravel
        });

        // 1. MAPPING DATA SECTIONS DARI DATABASE
        if (props.service.sections && props.service.sections.length > 0) {
            form.sections = props.service.sections.map(sec => {
                // Jika tipenya bukan text (yakni list/steps), gabungkan array items dengan Enter (\n)
                if (sec.type !== 'text' && Array.isArray(sec.items)) {
                    return { ...sec, content: sec.items.join('\n') };
                }
                return { ...sec, content: sec.content || '' };
            });
        } else {
            // Default form jika kosong
            form.sections = [{ title: '', type: 'text', content: '' }];
        }

        // 2. MAPPING DATA PACKAGES DARI DATABASE
        if (props.service.packages && props.service.packages.length > 0) {
            form.packages = props.service.packages.map(pkg => ({
                ...pkg,
                // Gabungkan array features dengan Enter (\n)
                features: Array.isArray(pkg.features) ? pkg.features.join('\n') : (pkg.features || '')
            }));
        }

        const initDropzone = () => {
            if (dropzoneInstance.value || !document.querySelector('#service-dropzone')) return;
            dropzoneInstance.value = new Dropzone('#service-dropzone', {
                url: '/', paramName: 'image', maxFiles: 1, maxFilesize: 10,
                acceptedFiles: 'image/jpeg,image/png,image/jpg,image/webp',
                autoProcessQueue: false, addRemoveLinks: true, dictRemoveFile: 'Hapus',
                init: function () {
                    this.on('addedfile', file => {
                        // Jangan override form.image jika file yang ditambahkan adalah mockFile dari database
                        if (!file.isExisting) form.image = file;
                    });
                    this.on('removedfile', () => form.image = null);
                    this.on('maxfilesexceeded', function(file) { this.removeAllFiles(); this.addFile(file); });
                },
            });

            // Tampilkan Gambar yang sudah ada di database
            if (props.service.image_url) {
                let mockFile = { 
                    name: props.service.image_name || 'image', 
                    size: props.service.image_size || 0, 
                    isExisting: true 
                };
                dropzoneInstance.value.displayExistingFile(mockFile, props.service.image_url);
            }
        };

        const initTinyMCE = () => {
            if (!window.tinymce) return;
            window.tinymce.init({
                selector: '#service-editor',
                apiKey: props.api_tinymce_key,
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline | link image | align | numlist bullist | removeformat',
                setup: function (editor) {
                    editor.on('init', () => {
                        if (form.description) {
                            editor.setContent(form.description);
                        }
                    });
                    editor.on('change', () => form.description = editor.getContent());
                }
            });
        };

        const addSection = () => form.sections.push({ title: '', type: 'list', content: '' });
        const removeSection = (idx) => form.sections.splice(idx, 1);

        const addPackage = () => form.packages.push({ name: '', price: '', badge_color: 'primary', recommendation: '', features: '' });
        const removePackage = (idx) => form.packages.splice(idx, 1);

        watch(() => form.has_packages, (isActivated) => {
            if (isActivated && form.packages.length === 0) addPackage();
        });

        const submit = () => {
            const submitBtn = document.querySelector('#submit_button');
            if (submitBtn) submitBtn.setAttribute('data-kt-indicator', 'on');

            // Pre-process Sections & Packages: Ubah string enter (\n) kembali jadi Array bersih
            const processedSections = form.sections.map(sec => {
                if (sec.type !== 'text') {
                    return { ...sec, items: sec.content ? sec.content.split('\n').map(i => i.trim()).filter(i => i) : [] };
                }
                return sec;
            });

            const processedPackages = form.packages.map(pkg => ({
                ...pkg,
                features: pkg.features ? pkg.features.split('\n').map(i => i.trim()).filter(i => i) : []
            }));

            const payload = new FormData();
            payload.append('_method', form._method); // Trik PUT file di Laravel / Inertia
            payload.append('name', form.name);
            payload.append('short_description', form.short_description);
            payload.append('description', form.description);
            payload.append('starting_price', form.starting_price || '');
            payload.append('has_packages', form.has_packages ? 1 : 0);
            
            payload.append('sections', JSON.stringify(processedSections));
            payload.append('packages', JSON.stringify(processedPackages));

            if (form.image) payload.append('image', form.image);

            // Perhatikan pengiriman ke route ID
            router.post(`/admin/services/${props.service.id}`, payload, {
                onSuccess: () => {
                    Swal.fire({
                        icon: 'success', title: 'Berhasil!', text: 'Layanan Berhasil Diperbarui!',
                        timer: 2000, timerProgressBar: true, showConfirmButton: false
                    });
                },
                onFinish: () => {
                    if (submitBtn) submitBtn.removeAttribute('data-kt-indicator');
                }
            });
        };

        onMounted(() => {
            nextTick(() => { initDropzone(); initTinyMCE(); });
        });

        return { form, addSection, removeSection, addPackage, removePackage, submit };
    }
}
</script>