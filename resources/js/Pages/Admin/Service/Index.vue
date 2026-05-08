<template>
    <Head>
        <title>Layanan − Admin {{ setting.site_title }}</title>
    </Head>

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div v-if="services.data.length < 3" class="d-flex align-items-center gap-4 bg-myprimary-light p-6 px-lg-8">
                <i class="ri-information-fill fs-2x text-myprimary"></i>
                <div class="d-flex flex-column">
                    <h4 class="fw-bolder text-myprimary mb-2">Informasi Tampilan Website</h4>
                    <span class="text-myprimary fw-semibold fs-7">
                        Masukkan setidaknya 3 layanan agar tampilan di website muncul & terlihat lebih proporsional & sejajar.
                    </span>
                </div>
            </div>
            <div id="kt_app_toolbar" class="app-toolbar py-7 py-lg-8">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <ol class="breadcrumb text-muted fs-6 fw-semibold mb-3">
                            <li class="breadcrumb-item pe-3">
                                <Link href="/admin/dashboard" class="btn-link-myprimary fw-bolder pe-3">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item pe-3 text-muted">Layanan</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Layanan</h1>
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
                                <Link href="/admin/services/create"
                                    class="w-100 w-md-auto btn btn-sm btn-myprimary-filled rounded-3 ps-5 fs-5 d-flex gap-1 align-items-center justify-content-center">
                                    <i class="fs-2 ri-add-line"></i>
                                    <span class="fw-bolder">Layanan</span>
                                </Link>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="text-center border-top border-gray-300 py-10 px-6" v-if="services.data.length === 0">
                                <img src="/assets/media/illustrations/empty.png"
                                    alt="Tidak ada data" class="mh-225px img-fluid mb-10">
                                <h2 class="text-dark mb-3 fw-bolder">Layanan Tidak Ditemukan</h2>
                                <p class="text-gray-600 fs-4 mb-0">Belum ada layanan atau pencarian tidak sesuai.</p>
                            </div>
                            <div class="table-responsive" v-else>
                                <table
                                    class="table table-hover align-middle table-row-bordered fs-5 gy-5 border-bottom border-gray-300 mb-0">
                                    <thead>
                                        <tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-20px ps-6 pe-5 bg-secondary" style="letter-spacing: 0.04em;">#</th>
                                            <th class="bg-secondary min-w-300px" style="letter-spacing: 0.04em;">Layanan</th>
                                            <th class="bg-secondary min-w-125px" style="letter-spacing: 0.04em;">Konten</th>
                                            <th class="bg-secondary min-w-125px" style="letter-spacing: 0.04em;">Harga</th>
                                            <th class="bg-secondary min-w-150px" style="letter-spacing: 0.04em;">Dibuat</th>
                                            <th class="bg-secondary pe-6 min-w-125px" style="letter-spacing: 0.04em;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="(service, index) in services.data" :key="service.id">
                                            <td class="ps-6">
                                                {{ ++index + (services.current_page - 1) * services.per_page }}
                                            </td>
                                            <td class="d-flex align-items-center gap-4">
                                                <div class="ratio ratio-1x1 w-40px w-md-45px flex-shrink-0">
                                                    <img class="h-100 rounded-3 img-fluid object-fit-cover"
                                                        :src="service.image_url || '/assets/media/illustrations/blog-placeholder.png'"
                                                        alt="Gambar Layanan" />
                                                </div>
                                                <div>
                                                    <p class="text-dark text-truncate-1 fs-5 fw-bolder mb-1">
                                                        {{ service.name }}
                                                    </p>
                                                    <p class="fs-7 mb-0 text-truncate-2">
                                                        {{ service.short_description }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-dark fs-5 fw-bold">
                                                    {{ getSectionsCount(service) }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-dark fs-5 fw-bold">
                                                    {{ getPricingDisplay(service) }}
                                                </p>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bolder fs-5 mb-1">{{ formatDate(service.created_at) }}</span>
                                                    <span class="fs-7">{{ formatTime(service.created_at) }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-6">
                                                <Link :href="`/admin/services/${service.id}/edit`"
                                                    class="btn btn-sm btn-icon btn-myprimary-tinted rounded-3 me-2">
                                                    <i class="ri-edit-2-fill fs-3"></i>
                                                </Link>
                                                <button @click.prevent="destroy(service.id)"
                                                    class="btn btn-sm btn-icon btn-mydanger-tinted rounded-3">
                                                    <i class="ri-delete-bin-fill fs-3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <Pagination v-if="services.data != 0"
                                :links="services.links" align="end" class="py-5 px-6" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LayoutAdmin from '../../../Layouts/Admin.vue';
    import Pagination from '../../../Components/Pagination.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import Swal from 'sweetalert2';

    export default {
        layout: LayoutAdmin,

        components: {
            Head,
            Link,
            Pagination
        },

        props: {
            setting: Object,
            services: Object,
        },

        setup(props) {
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));

            const handleSearch = () => {
                router.get('/admin/services', {
                    q: search.value,
                });
            };

            const getSectionsCount = (service) => {
                if (service.sections && Array.isArray(service.sections)) {
                    return `${service.sections.length} Konten`;
                }
                return '0 Konten';
            };
            
            // UPDATE LOGIKA HARGA
            const getPricingDisplay = (service) => {
                // Jika memiliki relasi paket (lebih dari 0)
                if (service.packages && service.packages.length > 0) {
                    return `${service.packages.length} Paket`;
                }
                // Jika tidak ada paket, tampilkan starting price, atau fallback '-'
                return service.starting_price || '-';
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
                        router.delete(`/admin/services/${id}`, {
                            onSuccess: () => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data Layanan Berhasil Dihapus!',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'swal-custom-icon',
                                    }
                                });
                            }
                        });
                    }
                });
            };

            return {
                search,
                handleSearch,
                getSectionsCount,
                getPricingDisplay,
                formatDate,
                formatTime,
                destroy,
            };
        }
    }
</script>