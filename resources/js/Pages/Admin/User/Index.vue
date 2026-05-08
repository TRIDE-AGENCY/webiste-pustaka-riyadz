<template>

    <Head>
        <title>Pengguna − Admin {{ setting.site_title }}</title>
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
                            <li class="breadcrumb-item pe-3 text-muted">Pengguna</li>
                        </ol>
                        <div class="page-heading">
                            <h1 class="mb-0 fw-bolder text-dark">Pengguna</h1>
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
                                    <span class="fw-bolder">Pengguna</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="text-center border-top border-gray-300 py-10 px-6"
                                v-if="users.data.length === 0">
                                <img src="/assets/media/illustrations/empty.png" alt="Tidak ada data"
                                    class="mh-225px img-fluid mb-10">
                                <h2 class="text-dark mb-3 fw-bolder">Pengguna Tidak Ditemukan</h2>
                                <p class="text-gray-600 fs-4 mb-0">Belum ada pengguna atau pencarian tidak sesuai.</p>
                            </div>
                            <div class="table-responsive" v-else>
                                <table
                                    class="table table-hover align-middle table-row-bordered fs-5 gy-5 border-bottom border-gray-300 mb-0">
                                    <thead>
                                        <tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-20px ps-6 pe-5 bg-secondary" style="letter-spacing: 0.04em;">#
                                            </th>
                                            <th class="bg-secondary min-w-250px" style="letter-spacing: 0.04em;">Nama
                                            </th>
                                            <th class="bg-secondary min-w-150px" style="letter-spacing: 0.04em;">Dibuat</th>
                                            <th class="bg-secondary pe-6 min-w-125px" style="letter-spacing: 0.04em;">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="(user, index) in users.data" :key="user.id">
                                            <td class="ps-6">
                                                {{ ++index + (users.current_page - 1) * users.per_page }}
                                            </td>
                                            <td class="d-flex align-items-center gap-4">
                                                <div class="symbol symbol-40px symbol-md-45px rounded-3">
                                                    <div class="symbol-label fs-4 fw-bolder rounded-3 bg-myprimary text-white">{{ getInitials (user . name) }}</div>
                                                </div>
                                                <div>
                                                    <p class="text-dark text-truncate-1 fs-5 fw-bolder mb-1">
                                                        {{ user.name }}
                                                    </p>
                                                    <p class="fs-7 mb-0 text-truncate-1">
                                                        {{ user.email }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bolder fs-5 mb-1">{{
                                                        formatDate(user.created_at) }}</span>
                                                    <span class="fs-7">{{ formatTime(user.created_at) }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-6">
                                                <button type="button" @click="openEditDrawer(user)"
                                                    class="btn btn-sm btn-icon btn-myprimary-tinted rounded-3 me-2">
                                                    <i class="ri-edit-2-fill fs-3"></i>
                                                </button>
                                                <button @click.prevent="destroy(user.id)"
                                                    class="btn btn-sm btn-icon btn-mydanger-tinted rounded-3">
                                                    <i class="ri-delete-bin-fill fs-3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <Pagination v-if="users.data != 0" :links="users.links" align="end"
                                class="py-5 px-6" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Transition name="fade">
            <div v-show="drawerOpen" class="drawer-backdrop" @click="closeDrawer"></div>
        </Transition>

        <Transition name="slide-drawer">
            <div v-show="drawerOpen" class="user-drawer bg-light shadow-sm">
                <div
                    class="d-flex align-items-center ps-6 pe-3 min-h-60px min-h-lg-70px gap-6 justify-content-between border-bottom border-gray-300">
                    <h2 class="mb-0 fw-bolder">{{ isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h2>
                    <div @click="closeDrawer" class="btn btn-sm btn-icon btn-mytertiary-ghost rounded-pill">
                        <i class="bi bi-x-lg fs-3"></i>
                    </div>
                </div>

                <form @submit.prevent="submit" class="d-flex flex-column h-100 overflow-auto">
                    <div class="flex-grow-1 p-6">
                        <div class="card rounded-4 border border-gray-300 mb-6">
                            <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300"
                                style="min-height: unset;">
                                <h3 class="mb-0 fw-bolder">Informasi Pengguna</h3>
                            </div>
                            <div class="card-body p-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label fs-6">Nama</label>
                                    <input type="text" class="form-control rounded-3 fs-5" v-model="form.name" required
                                        placeholder="Masukkan nama pengguna..." :class="{ 'is-invalid': errors.name }" />
                                    <div v-if="errors.name" class="text-mydanger mt-2">
                                        {{ errors.name }}
                                    </div>
                                </div>
                                <div class="fv-row">
                                    <label class="required form-label fs-6">Alamat Email</label>
                                    <input type="email" class="form-control rounded-3 fs-5" v-model="form.email" required
                                        placeholder="Masukkan email pengguna..." :class="{ 'is-invalid': errors.email }" />
                                    <div v-if="errors.email" class="text-mydanger mt-2">
                                        {{ errors.email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-4 border border-gray-300">
                            <div class="card-header p-6 d-flex flex-column m-0 border-bottom border-gray-300"
                                style="min-height: unset;">
                                <h3 class="mb-0 fw-bolder">Password</h3>
                                <p v-if="isEditMode"
                                    class="mt-2 mb-0 text-gray-600 fs-7">Kosongkan jika tidak ingin mengubah.</p>
                            </div>
                            <div class="card-body p-6">
                                <div class="mb-5 fv-row">
                                    <label :class="{ 'required': !isEditMode }" class="form-label fs-6">Password</label>
                                    <input type="password" class="form-control rounded-3 fs-5" v-model="form.password"
                                        :required="!isEditMode"
                                        placeholder="Masukkan password..." :class="{ 'is-invalid': errors.password }" />
                                    <div v-if="errors.password" class="text-mydanger mt-2">
                                        {{ errors.password }}
                                    </div>
                                </div>

                                <div class="fv-row">
                                    <label :class="{ 'required': !isEditMode }" class="form-label fs-6">Konfirmasi Password</label>
                                    <input type="password" class="form-control rounded-3 fs-5" v-model="form.password_confirmation"
                                        :required="!isEditMode"
                                        placeholder="Masukkan ulang password..." :class="{ 'is-invalid': errors.password_confirmation }" />
                                    <div v-if="errors.password_confirmation" class="text-mydanger mt-2">
                                        {{ errors.password_confirmation }}
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
                                {{ isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna' }}
                            </span>
                            <span class="indicator-progress">
                                Mohon Tunggu... <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
import { ref, reactive, onMounted, nextTick } from 'vue';
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
        errors: Object,
        users: Object,
    },

    setup(props) {
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));
        const drawerOpen = ref(false);
        const isEditMode = ref(false);
        const editingId = ref(null);

        const form = reactive({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        });

        const resetForm = () => {
            form.name = '';
            form.email = '';
            form.password = '';
            form.password_confirmation = '';
            editingId.value = null;
            isEditMode.value = false;
        };

        onMounted(() => {
            if (props.errors && Object.keys(props.errors).length > 0) {
                drawerOpen.value = true;
            }
        });

        const handleSearch = () => {
            router.get('/admin/users', {
                q: search.value,
            });
        };

        const openCreateDrawer = () => {
            resetForm();
            drawerOpen.value = true;
        };

        const openEditDrawer = (user) => {
            resetForm();
            isEditMode.value = true;
            editingId.value = user.id;
            form.name = user.name;
            form.email = user.email;
            drawerOpen.value = true;
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
            payload.append('name', form.name);
            payload.append('email', form.email);

            if (form.password) {
                payload.append('password', form.password);
                payload.append('password_confirmation', form.password_confirmation);
            }

            const cleanup = () => {
                if (submitBtn) {
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.removeAttribute('disabled');
                }
            };

            const requestUrl = isEditMode.value
                ? `/admin/users/${editingId.value}`
                : '/admin/users';

            if (isEditMode.value) {
                payload.append('_method', 'PUT');
            }

            router.post(requestUrl, payload, {
                onSuccess: () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: isEditMode.value
                            ? 'Data Pengguna Berhasil Diperbarui!'
                            : 'Data Pengguna Berhasil Disimpan!',
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
                    router.delete(`/admin/users/${id}`, {
                        onSuccess: () => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Pengguna berhasil dihapus.',
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

        const getInitials = (name) => {
            if (!name) return '';
            return name
                .split(' ')               
                .map(word => word[0])   
                .join('') 
                .substring(0, 2)              
                .toUpperCase();          
        };

        return {
            search,
            drawerOpen,
            isEditMode,
            editingId,
            form,
            handleSearch,
            openCreateDrawer,
            openEditDrawer,
            closeDrawer,
            formatDate,
            formatTime,
            submit,
            destroy,
            getInitials
        };
    }
};
</script>

<style scoped>
.user-drawer {
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

.drawer-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(11, 18, 32, 0.35);
    backdrop-filter: blur(3px);
    z-index: 1045;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-drawer-enter-active,
.slide-drawer-leave-active {
    transition: transform 0.3s ease;
}

.slide-drawer-enter-from,
.slide-drawer-leave-to {
    transform: translateX(100%);
}

@media (max-width: 768px) {
    .user-drawer {
        max-width: 100%;
    }
}
</style>
