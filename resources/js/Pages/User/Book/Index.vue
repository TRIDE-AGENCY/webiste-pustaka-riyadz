<template>
    <Head>
        <title>{{ pageTitle }}</title>
    </Head>

    <LayoutUser :setting="setting">
        <section class="bg-white pt-20 position-relative border-bottom border-gray-300">
            <div class="container mw-1100px mx-auto position-relative z-index-1">
                <div class="mt-md-10 d-flex flex-column align-items-center text-center">
                    <div class="book-index-hero-icon mb-12" aria-hidden="true">
                        <i class="ri-book-open-fill text-white"></i>
                    </div>
                    <h1 class="text-dark fs-3hx fw-bolder mb-8">
                        Daftar Buku Kami
                    </h1>
                    <p class="text-gray-600 fs-3 fs-md-2 fw-semibold mb-20 pb-md-10 mw-800px mw-xl-900px lh-lg">
                        Jelajahi katalog buku yang tersedia dan pilih judul yang ingin Anda pesan.
                    </p>
                </div>
            </div>
        </section>
        <section class="container w-100 mw-1100px mx-auto pt-20 mt-md-10">
            <div v-if="safeBooks.length" class="d-flex flex-column gap-6">
                <div class="book-index-grid">
                    <article v-for="book in safeBooks" :key="book.id"
                        class="book-index-card d-flex flex-column bg-white rounded-4 p-2 border border-gray-300 h-100 cursor-pointer"
                        role="button" tabindex="0" @click="goToBook(book)" @keydown.enter.prevent="goToBook(book)"
                        @keydown.space.prevent="goToBook(book)">
                        <img :src="book.image || fallbackImage" :alt="book.title" class="book-index-image img-fluid rounded-3"
                            @error="setFallbackImage">
                        <div class="p-6 pt-8 d-flex flex-column flex-grow-1">
                            <h3 class="text-dark fw-bolder fs-2 mb-2">
                                {{ book.title }}
                            </h3>
                            <p class="text-gray-600 fs-5 fw-semibold mb-4">
                                {{ book.author || 'Penulis belum tersedia' }} <span v-if="book.year">• {{ book.year }}</span>
                            </p>
                            <div class="d-flex align-items-center w-100 gap-2 mt-auto pt-5 border-top border-gray-300">
                                <div class="flex-fill">
                                    <span class="mb-1 fs-6 text-gray-600 fw-semibold">Harga</span>
                                    <p class="fs-3 text-dark fw-bolder mb-0 mt-1">
                                        {{ formatPrice(book.price) }}
                                    </p>
                                </div>
                                <a :href="whatsappLink" target="_blank" @click.stop
                                    class="btn btn-sm fs-5 btn-myprimary-filled rounded-3 fw-bolder d-inline-flex align-items-center gap-1">
                                    <i class="ri-whatsapp-line fs-3"></i>
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <Pagination v-if="books.last_page > 1" :links="books.links" align="center"
                    class="book-index-pagination" />
            </div>

            <div v-else class="book-index-empty bg-white border border-gray-300 rounded-4 p-8 p-md-12 text-center">
                <img src="/assets/media/illustrations/empty.png" alt="Tidak ada buku"
                    class="img-fluid mh-225px mb-8 mx-auto">
                <h2 class="text-dark fw-bolder fs-1 mb-3">Buku Tidak Ditemukan</h2>
                <p class="text-gray-600 fs-5 fw-semibold mb-6">
                    Belum ada buku atau kata kunci pencarian tidak cocok.
                </p>
                <button v-if="filters.q" type="button" class="btn btn-myprimary-filled rounded-3 fw-bolder fs-5"
                    @click="clearSearch">
                    Tampilkan Semua Buku
                </button>
            </div>
        </section>
    </LayoutUser>
</template>

<script>
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import LayoutUser from '../../../Layouts/User.vue';
import Pagination from '../../../Components/Pagination.vue';

export default {
    components: {
        Head,
        Link,
        LayoutUser,
        Pagination,
    },

    props: {
        books: {
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
        const fallbackImage = '/assets/media/illustrations/img-book.png';
        const search = ref(props.filters?.q || '');

        const safeBooks = computed(() => props.books?.data || []);
        const pageTitle = computed(() => `Daftar Buku − ${props.setting?.site_title || 'Pustaka Riyadz'}`);
        const whatsappNumber = computed(() => {
            const raw = props.setting?.whatsapp;

            if (!raw) {
                return '';
            }

            let number = raw.toString().replace(/\D/g, '');

            if (number.startsWith('0')) {
                number = `62${number.substring(1)}`;
            } else if (!number.startsWith('62')) {
                number = `62${number}`;
            }

            return number;
        });
        const whatsappLink = computed(() => {
            return whatsappNumber.value ? `https://wa.me/${whatsappNumber.value}` : '/#contact';
        });
        const resultSummary = computed(() => {
            const from = props.books?.from || 0;
            const to = props.books?.to || 0;
            const total = props.books?.total || 0;

            return `Menampilkan ${from}-${to} dari ${total} buku`;
        });

        const handleSearch = () => {
            router.get('/books', {
                q: search.value || undefined,
            }, {
                preserveState: true,
                replace: true,
            });
        };

        const clearSearch = () => {
            search.value = '';
            router.get('/books', {}, {
                preserveState: true,
                replace: true,
            });
        };

        const goToBook = (book) => {
            if (book?.slug) {
                router.visit(`/books/${book.slug}`);
            }
        };

        const formatPrice = (price) => {
            if (price === null || price === undefined || price === '') {
                return 'Hub. Admin';
            }

            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }).format(Number(price));
        };

        const setFallbackImage = (event) => {
            event.target.src = fallbackImage;
        };

        return {
            fallbackImage,
            search,
            safeBooks,
            pageTitle,
            whatsappLink,
            resultSummary,
            handleSearch,
            clearSearch,
            goToBook,
            formatPrice,
            setFallbackImage,
        };
    },
};
</script>

<style scoped>
.book-index-head,
.book-index-empty {
    box-shadow: 0 16px 42px rgba(15, 23, 42, 0.04);
}

.book-index-eyebrow {
    min-height: 36px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border-radius: 999px;
    background: var(--base-color-100);
    color: var(--base-color-700);
    padding: 0.55rem 0.95rem;
    font-size: 0.92rem;
    font-weight: 800;
}

.book-index-hero-icon {
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

.book-index-hero-icon::before,
.book-index-hero-icon::after {
    position: absolute;
    inset: 0;
    z-index: -1;
    border-radius: inherit;
    background: var(--base-color-500);
    content: "";
    animation: bookIndexHeroPulse 2s ease-out infinite;
}

.book-index-hero-icon::after {
    animation-delay: 1s;
}

.book-index-hero-icon i {
    font-size: 2.75rem;
    line-height: 1;
}

@keyframes bookIndexHeroPulse {
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

.book-index-search {
    width: min(100%, 440px);
    display: grid;
    grid-template-columns: auto minmax(0, 1fr) auto auto;
    align-items: center;
    gap: 0.45rem;
    border: 1px solid var(--bs-gray-300);
    border-radius: 0.85rem;
    background: #f8fafc;
    padding: 0.45rem;
}

.book-index-search > i {
    margin-left: 0.75rem;
}

.book-index-search .form-control {
    min-width: 0;
    border: 0;
    background: transparent;
    padding-left: 0.35rem;
}

.book-index-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.75rem;
}

.book-index-card {
    min-width: 0;
}

.book-index-cover {
    display: block;
    background: #f8fafc;
}

.book-index-image {
    width: 100%;
    height: auto;
    display: block;
}

.book-index-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    padding: 1.5rem;
}

.book-index-chip {
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

.book-index-chip-muted {
    border-color: rgba(100, 116, 139, 0.14);
    background: #f1f5f9;
    color: #64748b;
}

.book-index-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-top: auto;
    padding-top: 1.25rem;
    border-top: 1px solid var(--bs-gray-300);
}

.book-index-pagination {
    display: flex;
    justify-content: center;
    padding-top: 1rem;
}

@media (max-width: 991.98px) {
    .book-index-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575.98px) {
    .book-index-page {
        padding-bottom: 7.5rem;
    }

    .book-index-search {
        grid-template-columns: auto minmax(0, 1fr) auto;
    }

    .book-index-search .btn[type="submit"] {
        grid-column: 1 / -1;
        justify-content: center;
    }

    .book-index-grid {
        grid-template-columns: 1fr;
    }

    .book-index-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .book-index-footer .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
