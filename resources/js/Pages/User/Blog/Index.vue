<template>
    <Head>
        <title>{{ pageTitle }}</title>
    </Head>

    <LayoutUser :setting="setting">
        <section class="bg-white pt-20 position-relative border-bottom border-gray-300">
            <div class="container mw-1100px mx-auto position-relative z-index-1">
                <div class="mt-md-10 d-flex flex-column align-items-center text-center">
                    <div class="blog-index-hero-icon mb-12" aria-hidden="true">
                        <i class="ri-blogger-fill text-white"></i>
                    </div>
                    <h1 class="text-dark fs-3hx fw-bolder mb-8">
                        Blog dan Artikel
                    </h1>
                    <p class="text-gray-600 fs-3 fs-md-2 fw-semibold mb-20 pb-md-10 mw-800px mw-xl-900px lh-lg">
                        Temukan bacaan terbaru seputar penerbitan, literasi, dan lainnya.
                    </p>
                </div>
            </div>
        </section>
        <section class="container w-100 mw-1100px mx-auto pt-20 mt-md-10">
            <div v-if="safeBlogs.length" class="d-flex flex-column gap-6">
                <div class="blog-index-grid">
                    <article
                        v-for="blog in safeBlogs"
                        :key="blog.id"
                        class="d-flex flex-column bg-white rounded-4 p-2 border border-gray-300 h-100 cursor-pointer"
                        role="button" tabindex="0" @click="goToBlog(blog)"
                        @keydown.enter.prevent="goToBlog(blog)"
                        @keydown.space.prevent="goToBlog(blog)">
                        <div class="ratio ratio-4x3 rounded-3 overflow-hidden">
                            <img
                                :src="blog.image || fallbackImage"
                                :alt="blog.title"
                                class="img-fluid object-fit-cover w-100 h-100"
                                @error="setFallbackImage"
                            >
                        </div>
                        <div class="p-6 pt-8 d-flex flex-column flex-grow-1">
                            <h3 class="text-dark fw-bolder text-truncate-2 fs-2 mb-2">{{ blog.title }}</h3>
                            <p class="text-gray-600 fs-5 fw-semibold mb-0">{{ formatDate(blog.created_at) }}</p>
                        </div>
                    </article>
                </div>

                <Pagination
                    v-if="blogs.last_page > 1"
                    :links="blogs.links"
                    align="center"
                    class="blog-index-pagination"
                />
            </div>

            <div v-else class="blog-index-empty bg-white border border-gray-300 rounded-4 p-8 p-md-12 text-center">
                <img src="/assets/media/illustrations/empty.png" alt="Tidak ada blog"
                    class="img-fluid mh-225px mb-8 mx-auto">
                <h2 class="text-dark fw-bolder fs-1 mb-3">Blog Tidak Ditemukan</h2>
                <p class="text-gray-600 fs-5 fw-semibold mb-6">
                    Belum ada blog yang terbit atau kata kunci pencarian tidak cocok.
                </p>
                <button
                    v-if="filters.q"
                    type="button"
                    class="btn btn-myprimary-filled rounded-3 fw-bolder fs-5"
                    @click="clearSearch"
                >
                    Tampilkan Semua Blog
                </button>
            </div>
        </section>
    </LayoutUser>
</template>

<script>
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import LayoutUser from '../../../Layouts/User.vue';
import Pagination from '../../../Components/Pagination.vue';

export default {
    components: {
        Head,
        LayoutUser,
        Pagination,
    },

    props: {
        blogs: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
        setting: {
            type: Object,
            default: () => ({}),
        },
    },

    setup(props) {
        const fallbackImage = '/assets/media/illustrations/img-hero.png';
        const search = ref(props.filters?.q || '');

        const safeBlogs = computed(() => props.blogs?.data || []);
        const pageTitle = computed(() => `Blog dan Artikel − ${props.setting?.site_title || 'Pustaka Riyadz'}`);
        const resultSummary = computed(() => {
            const from = props.blogs?.from || 0;
            const to = props.blogs?.to || 0;
            const total = props.blogs?.total || 0;

            return `Menampilkan ${from}-${to} dari ${total} blog`;
        });

        const handleSearch = () => {
            router.get('/blogs', {
                q: search.value || undefined,
            }, {
                preserveState: true,
                replace: true,
            });
        };

        const clearSearch = () => {
            search.value = '';
            router.get('/blogs', {}, {
                preserveState: true,
                replace: true,
            });
        };

        const goToBlog = (blog) => {
            if (blog?.slug) {
                router.visit(`/blogs/${blog.slug}`);
            }
        };

        const formatViews = (views) => {
            const total = Number(views || 0);
            return `${new Intl.NumberFormat('id-ID').format(total)}x dilihat`;
        };

        const formatDate = (date) => {
            if (!date) {
                return 'Tanggal belum tersedia';
            }

            const parsedDate = new Date(date);

            if (Number.isNaN(parsedDate.getTime())) {
                return date;
            }

            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
            }).format(parsedDate);
        };

        const setFallbackImage = (event) => {
            event.target.src = fallbackImage;
        };

        return {
            fallbackImage,
            search,
            safeBlogs,
            pageTitle,
            resultSummary,
            handleSearch,
            clearSearch,
            goToBlog,
            formatViews,
            formatDate,
            setFallbackImage,
        };
    },
};
</script>

<style scoped>
.blog-index-page {
    padding-bottom: 10rem;
}

.blog-index-empty {
    box-shadow: 0 16px 42px rgba(15, 23, 42, 0.04);
}

.blog-index-hero-icon {
   position: relative;
    isolation: isolate;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    border-radius: 999px;
    background: var(--base-color-500);
}

.blog-index-hero-icon::before,
.blog-index-hero-icon::after {
    position: absolute;
    inset: 0;
    z-index: -1;
    border-radius: inherit;
    background: var(--base-color-500);
    content: "";
    animation: blogIndexHeroPulse 2s ease-out infinite;
}

.blog-index-hero-icon::after {
    animation-delay: 1s;
}

.blog-index-hero-icon i {
    font-size: 2.75rem;
    line-height: 1;
}

@keyframes blogIndexHeroPulse {
    0% {
        opacity: 0.58;
        transform: scale(0.92);
    }
    70%,
    100% {
        opacity: 0;
        transform: scale(1.55);
    }
}

.blog-index-search {
    width: min(100%, 500px);
    display: grid;
    grid-template-columns: auto minmax(0, 1fr) auto auto;
    align-items: center;
    gap: 0.45rem;
    border: 1px solid var(--bs-gray-300);
    border-radius: 0.85rem;
    background: #f8fafc;
    padding: 0.45rem;
}

.blog-index-search > i {
    margin-left: 0.75rem;
}

.blog-index-search .form-control {
    min-width: 0;
    border: 0;
    background: transparent;
    padding-left: 0.35rem;
}

.blog-index-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.75rem;
}

.blog-index-card {
    min-width: 0;
}

.blog-index-image-wrap {
    aspect-ratio: 4 / 3;
    background: #ffffff;
}

.blog-index-image {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.blog-index-chip {
    display: inline-flex;
    align-items: center;
    min-height: 30px;
    border: 1px solid rgba(249, 115, 22, 0.14);
    border-radius: 999px;
    background: #fff7ed;
    color: var(--base-color-700);
    padding: 0.35rem 0.7rem;
    font-size: 0.74rem;
    font-weight: 800;
}

.blog-index-chip-muted {
    border-color: rgba(100, 116, 139, 0.14);
    background: #f1f5f9;
    color: #64748b;
}

.blog-index-title {
    display: -webkit-box;
    overflow: hidden;
    min-height: 4.75rem;
    line-height: 1.2;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.blog-index-excerpt {
    display: -webkit-box;
    overflow: hidden;
    min-height: 6.5rem;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

.blog-index-pagination {
    display: flex;
    justify-content: center;
    padding-top: 1rem;
}

@media (max-width: 991.98px) {
    .blog-index-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575.98px) {
    .blog-index-page {
        padding-bottom: 7.5rem;
    }

    .blog-index-search {
        grid-template-columns: auto minmax(0, 1fr) auto;
    }

    .blog-index-search .btn[type="submit"] {
        grid-column: 1 / -1;
        justify-content: center;
    }

    .blog-index-grid {
        grid-template-columns: 1fr;
    }
}
</style>
