<template>

    <Head>
        <title>{{ pageTitle }}</title>
    </Head>

    <LayoutUser :setting="setting" navbar-default-bg="bg-light">
        <section class="container w-100 mw-1100px mx-auto pt-20">
            <button type="button"
                class="btn btn-sm btn-myprimary-tinted rounded-3 fw-bolder fs-6 d-inline-flex align-items-center gap-2 mb-8"
                @click="goBack">
                <i class="ms-n1 ri-arrow-left-line fs-4"></i>
                Kembali
            </button>

            <div class="book-detail-hero row g-8 g-xl-10">
                <div class="col-12 col-md-5 book-detail-gallery-column">
                    <div class="book-detail-gallery">
                        <div class="book-detail-slider-wrap">
                            <Swiper class="book-image-swiper" :modules="imageSliderModules" :slides-per-view="1"
                                :space-between="0" :auto-height="true" :rewind="safeImages.length > 1"
                                :pagination="safeImages.length > 1 ? { clickable: true } : false"
                                @swiper="setImageSwiper" @slideChange="handleImageSlideChange">
                                <SwiperSlide v-for="(image, index) in safeImages" :key="`${image}-${index}`">
                                    <div class="book-detail-frame overflow-hidden">
                                        <img :src="image" :alt="`${book.title} ${index + 1}`" class="book-detail-image"
                                            @error="setFallbackImage">
                                    </div>
                                </SwiperSlide>
                            </Swiper>

                            <button v-if="safeImages.length > 1" type="button"
                                class="book-detail-nav book-detail-nav-prev" aria-label="Gambar sebelumnya"
                                @click="previousImage">
                                <i class="ri-arrow-left-s-line text-white fs-1"></i>
                            </button>
                            <button v-if="safeImages.length > 1" type="button"
                                class="book-detail-nav book-detail-nav-next" aria-label="Gambar berikutnya"
                                @click="nextImage">
                                <i class="ri-arrow-right-s-line text-white fs-1"></i>
                            </button>
                        </div>

                        <div v-if="safeImages.length > 1" class="book-detail-indicators d-none d-md-flex">
                            <button v-for="(image, index) in safeImages" :key="`${image}-${index}`" type="button"
                                class="book-detail-thumb" :class="{ active: activeImageIndex === index }"
                                :aria-label="`Tampilkan gambar ${index + 1}`" @click="setActiveImage(index)">
                                <img :src="image" :alt="`${book.title} thumbnail ${index + 1}`"
                                    @error="setFallbackImage">
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-7">
                    <div class="bg-white border border-gray-300 rounded-4 p-7 p-md-9">
                        <h1 class="text-dark fw-bolder lh-sm fs-2x fs-md-2tx mb-7">
                            {{ book.title }}
                        </h1>

                        <div class="book-detail-byline d-flex flex-column gap-3 mb-8">
                            <div v-if="book.author" class="d-flex align-items-center gap-3">
                                <i class="ri-quill-pen-fill fs-3 text-myprimary"></i>
                                <span class="text-dark fs-4 fw-bolder">{{ book.author }}</span>
                            </div>
                            <div v-if="book.publisher" class="d-flex align-items-center gap-3">
                                <i class="ri-building-4-fill fs-3 text-myprimary"></i>
                                <span class="text-dark fs-4 fw-bolder">{{ book.publisher }}</span>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-5 align-items-sm-end justify-content-sm-between bg-light rounded-3 border border-gray-200 p-6 p-md-7">
                            <div>
                                <span class="d-block text-gray-600 fs-6 fw-semibold mb-2">Harga Buku</span>
                                <strong class="text-dark fs-1 fw-bolder">{{ formatPrice(book.price) }}</strong>
                            </div>
                            <a :href="whatsappLink" target="_blank"
                                class="btn btn-myprimary-filled rounded-3 fw-bolder fs-5 d-inline-flex align-items-center justify-content-center gap-1">
                                <i class="ri-whatsapp-line fs-3"></i>
                                Pesan Buku
                            </a>
                        </div>
                    </div>

                    <div class="book-detail-content mt-6 mt-md-8">
                        <section class="bg-white border border-gray-300 rounded-4 p-7 p-md-9">
                            <div class="d-flex align-items-center gap-3 mb-7 mb-md-9">
                                <i class="ri-information-fill fs-2x text-myprimary fs-2"></i>
                                <h2 class="text-dark fw-bolder fs-1 mb-0">Informasi Buku</h2>
                            </div>

                            <div class="book-detail-meta-grid">
                                <div v-for="item in metaItems" :key="item.label" class="bg-light border border-gray-200 rounded-3 px-6 px-md-7 py-5">
                                    <span class="d-block text-gray-600 fs-6 fw-semibold mb-2">{{ item.label }}</span>
                                    <strong class="d-block text-dark fs-4 fw-bolder mt-2">
                                        {{ item.value }}
                                    </strong>
                                </div>
                            </div>
                        </section>

                        <section class="bg-white border border-gray-300 rounded-4 p-7 p-md-9">
                            <div class="d-flex align-items-center gap-3 mb-7 mb-md-9">
                                <i class="ri-file-text-fill fs-2x text-myprimary fs-2"></i>
                                <h2 class="text-dark fw-bolder fs-1 mb-0">Deskripsi Buku</h2>
                            </div>

                            <div v-if="book.description"
                                class="book-detail-description editor-content text-dark fs-4 fw-semibold lh-lg"
                                v-html="book.description"></div>
                            <p v-else class="text-gray-600 fs-5 fw-semibold mb-0">
                                Deskripsi buku belum tersedia.
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </LayoutUser>
</template>

<script>
import { Head, router } from '@inertiajs/vue3';
import LayoutUser from '../../../Layouts/User.vue';
import { computed, ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { A11y, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

export default {
    components: {
        Head,
        LayoutUser,
        Swiper,
        SwiperSlide,
    },

    props: {
        book: {
            type: Object,
            required: true,
        },
        setting: {
            type: Object,
            default: () => ({}),
        },
    },

    setup(props) {
        const activeImageIndex = ref(0);
        const imageSwiper = ref(null);
        const fallbackImage = '/assets/media/illustrations/img-book.png';
        const imageSliderModules = [A11y, Pagination];

        const pageTitle = computed(() => {
            return `${props.book.title} − ${props.setting?.site_title || 'Pustaka Riyadz'}`;
        });

        const safeImages = computed(() => {
            const images = props.book.images?.length
                ? props.book.images
                : [props.book.image];

            const validImages = images.filter(Boolean);

            return validImages.length ? validImages : [fallbackImage];
        });

        const metaItems = computed(() => [
            { label: 'Kategori', value: props.book.category },
            { label: 'Subjek', value: props.book.subject },
            { label: 'ISBN', value: props.book.isbn },
            { label: 'Tahun', value: props.book.year },
            { label: 'Dimensi', value: props.book.dimensions },
            { label: 'Halaman', value: props.book.pages },
        ].filter((item) => item.value));

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
            if (!whatsappNumber.value) {
                return '/#contact';
            }

            const message = encodeURIComponent(`Halo, saya ingin pesan buku "${props.book.title}".`);
            return `https://wa.me/${whatsappNumber.value}?text=${message}`;
        });

        const setActiveImage = (index) => {
            activeImageIndex.value = index;
            imageSwiper.value?.slideTo(index);
        };

        const nextImage = () => {
            imageSwiper.value?.slideNext();
        };

        const previousImage = () => {
            imageSwiper.value?.slidePrev();
        };

        const setImageSwiper = (swiper) => {
            imageSwiper.value = swiper;
        };

        const handleImageSlideChange = (swiper) => {
            activeImageIndex.value = swiper.realIndex ?? swiper.activeIndex;
        };

        const goBack = () => {
            if (window.history.length > 1) {
                window.history.back();
                return;
            }

            router.visit('/books');
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
            activeImageIndex,
            imageSliderModules,
            pageTitle,
            safeImages,
            metaItems,
            whatsappLink,
            setActiveImage,
            nextImage,
            previousImage,
            setImageSwiper,
            handleImageSlideChange,
            goBack,
            formatPrice,
            setFallbackImage,
        };
    },
};
</script>

<style scoped>
.book-detail-hero {
    align-items: flex-start;
}

.book-detail-gallery-column {
    position: sticky;
    top: 128px;
    align-self: flex-start;
    max-height: calc(100vh - 130px);
    overflow-y: auto;
    overscroll-behavior: contain;
    scrollbar-width: thin;
}

.book-detail-gallery {
    position: relative;
}

.book-detail-slider-wrap {
    position: relative;
}

.book-image-swiper {
    position: relative;
    overflow: hidden;
    border: 1px solid var(--bs-gray-300);
    border-radius: 1rem;
    background: #ffffff;
}

.book-image-swiper :deep(.swiper-wrapper) {
    align-items: flex-start;
}

.book-image-swiper :deep(.swiper-slide) {
    height: auto;
}

.book-image-swiper :deep(.swiper-pagination) {
    position: absolute;
    right: 0;
    bottom: 1rem;
    left: 0;
    z-index: 3;
    display: flex;
    justify-content: center;
    gap: 0.35rem;
    padding: 0;
    line-height: 1;
}

.book-image-swiper :deep(.swiper-pagination-bullet) {
    width: 8px;
    height: 8px;
    margin: 0;
    background: #cbd5e1;
    opacity: 1;
}

.book-image-swiper :deep(.swiper-pagination-bullet-active) {
    width: 22px;
    border-radius: 99px;
    background: var(--base-color-500);
}

.book-detail-frame {
    position: relative;
    border-radius: 1rem;
    background: #ffffff;
}

.book-detail-image {
    width: 100%;
    height: auto;
    display: block;
}

.book-detail-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.book-detail-section-icon {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    border-radius: 999px;
    background: var(--base-color-100);
    color: var(--base-color-600);
}

.book-detail-nav {
    position: absolute;
    top: 50%;
    z-index: 2;
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 99px;
    background: rgba(15, 23, 42, 0.42);
    color: #ffffff;
    transform: translateY(-50%);
    transition: background 0.2s ease, transform 0.2s ease;
}

.book-detail-nav:hover {
    background: rgba(15, 23, 42, 0.7);
    transform: translateY(-50%) scale(1.04);
}

.book-detail-nav-prev {
    left: 1rem;
}

.book-detail-nav-next {
    right: 1rem;
}

.book-detail-indicators {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.85rem;
    margin-top: 1rem;
}

.book-detail-thumb {
    width: 76px;
    aspect-ratio: 1 / 1;
    border: 1px solid var(--bs-gray-300);
    border-radius: 0.75rem;
    background: #ffffff;
    padding: 0rem;
    overflow: hidden;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.book-detail-thumb.active {
    border-color: var(--base-color-500);
    box-shadow: 0 0 0 3px var(--base-color-100);
}

.book-detail-thumb:hover {
    transform: translateY(-2px);
}

.book-detail-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.65rem;
}

.book-detail-chip {
    display: inline-flex;
    align-items: center;
    min-height: 34px;
    border: 1px solid rgba(249, 115, 22, 0.14);
    border-radius: 999px;
    background: #fff7ed;
    color: var(--base-color-700);
    padding: 0.45rem 0.8rem;
    font-size: 0.78rem;
    font-weight: 800;
}

.book-detail-chip-muted {
    border-color: rgba(100, 116, 139, 0.14);
    background: #f1f5f9;
    color: #64748b;
}

.book-detail-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.5rem;
}

.book-detail-meta-item strong {
    overflow-wrap: anywhere;
}

.book-detail-description {
    max-width: 100%;
}

.book-detail-description :deep(p:last-child) {
    margin-bottom: 0;
}

.book-detail-description :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

@media (max-width: 991.98px) {
    .book-detail-gallery-column {
        position: static;
        max-height: none;
        overflow: visible;
    }
}

@media (max-width: 575.98px) {
    .book-detail-content {
        gap: 1rem;
    }

    .book-detail-meta-grid {
        grid-template-columns: 1fr;
    }

    .book-detail-nav {
        width: 38px;
        height: 38px;
    }

    .book-detail-nav-prev {
        left: 0.75rem;
    }

    .book-detail-nav-next {
        right: 0.75rem;
    }
}
</style>
