<template>
    <Head>
        <title>{{ pageTitle }}</title>
        <meta name="description" :content="description" />

        <meta property="og:type" content="article" />
        <meta property="og:url" :content="current_url" />
        <meta property="og:title" :content="blog.title" />
        <meta property="og:description" :content="description" />
        <meta v-if="blogImageUrl" property="og:image" :content="blogImageUrl" />

        <meta property="twitter:card" content="summary_large_image" />
        <meta property="twitter:url" :content="current_url" />
        <meta property="twitter:title" :content="blog.title" />
        <meta property="twitter:description" :content="description" />
        <meta v-if="blogImageUrl" property="twitter:image" :content="blogImageUrl" />
    </Head>

    <LayoutUser :setting="setting" navbar-default-bg="bg-light">
        <section class="container w-100 mw-1100px mx-auto pt-20">
            <button type="button"
                class="btn btn-sm btn-myprimary-tinted rounded-3 fw-bolder fs-6 d-inline-flex align-items-center gap-2 mb-8"
                @click="goBack">
                <i class="ms-n1 ri-arrow-left-line fs-4"></i>
                Kembali
            </button>

            <article v-if="blogImageUrl" class="mb-8 mb-md-10 bg-white border border-gray-300 rounded-4 overflow-hidden">
                <div class="blog-detail-cover">
                    <img :src="imageUrl(blog.image)" :alt="blog.title" class="blog-detail-cover-image">
                </div>
            </article>

            <div class="row g-8 g-xl-10 align-items-start">
                <div class="col-12 col-md-8">
                    <article class="bg-white border border-gray-300 rounded-4 p-7 p-md-10">
                        <h1 class="text-dark fw-bolder lh-sm fs-2x fs-md-2tx mb-7">
                            {{ blog.title }}
                        </h1>
                        <div v-if="blog.content" class="blog-detail-content editor-content text-dark fs-4 fw-semibold lh-lg" v-html="blog.content"></div>
                        <p v-else class="text-gray-600 fs-5 fw-semibold mb-0">
                            Konten blog belum tersedia.
                        </p>
                    </article>
                </div>

                <aside class="col-12 col-md-4 blog-detail-sidebar">
                    <section class="bg-white border border-gray-300 rounded-4 p-6 p-md-7">
                        <div class="d-flex align-items-center gap-3 mb-7 mb-md-9">
                            <i class="ri-information-fill fs-2x text-myprimary fs-2"></i>
                            <h2 class="text-dark fw-bolder fs-1 mb-0">Info Blog</h2>
                        </div>
                        <div class="d-flex flex-column gap-4">
                            <div v-if="blogAuthorName">
                                <span class="d-block text-gray-600 fs-6 fw-semibold mb-2">Penulis</span>
                                <strong class="text-dark fs-4 fw-bolder">{{ blogAuthorName }}</strong>
                            </div>
                            <div>
                                <span class="d-block text-gray-600 fs-6 fw-semibold mb-2">Diterbitkan</span>
                                <strong class="text-dark fs-4 fw-bolder">{{ formatDate(blog.created_at) }}</strong>
                            </div>
                            <!-- <div>
                                <span class="d-block text-gray-600 fs-6 fw-semibold mb-2">Terakhir Diperbarui</span>
                                <strong class="text-dark fs-4 fw-bolder">{{ formatDate(blog.updated_at) }}</strong>
                            </div> -->
                            <div>
                                <span class="d-block text-gray-600 fs-6 fw-semibold mb-2">Dilihat</span>
                                <strong class="text-dark fs-4 fw-bolder">{{ formatViews(blog.views) }}</strong>
                            </div>
                        </div>
                    </section>

                    <section class="bg-white border border-gray-300 rounded-4 p-6 p-md-7 mt-6">
                        <div class="d-flex align-items-center gap-3 mb-6">
                            <i class="ri-share-forward-fill fs-2x text-myprimary fs-2"></i>
                            <h2 class="text-dark fw-bolder fs-1 mb-0">Bagikan</h2>
                        </div>

                        <div class="d-flex flex-column gap-4">
                           

                            <button type="button"
                                class="btn btn-myprimary-tinted rounded-3 fw-bolder fs-5 d-flex align-items-center justify-content-center gap-1"
                                @click="copyShareLink">
                                <i :class="[copyLabel === 'Tersalin' ? 'ri-check-line' : 'ri-link-m', 'fs-3']"></i>
                                {{ copyLabel }}
                            </button>

                            <div class="blog-share-grid">
                                <a :href="whatsappShareUrl" target="_blank" rel="noopener"
                                    class="btn btn-icon btn-myprimary-tinted w-100" aria-label="Bagikan ke WhatsApp">
                                    <i class="ri-whatsapp-line fs-2"></i>
                                </a>
                                <a :href="facebookShareUrl" target="_blank" rel="noopener"
                                    class="btn btn-icon btn-myprimary-tinted w-100" aria-label="Bagikan ke Facebook">
                                    <i class="ri-facebook-box-fill fs-2"></i>
                                </a>
                                <a :href="twitterShareUrl" target="_blank" rel="noopener"
                                    class="btn btn-icon btn-myprimary-tinted w-100" aria-label="Bagikan ke Twitter">
                                    <i class="ri-twitter-x-line fs-2"></i>
                                </a>
                            </div>
                             <button type="button"
                                class="btn btn-myprimary-filled rounded-3 fw-bolder fs-5 d-flex align-items-center justify-content-center gap-1"
                                @click="shareArticle">
                                Bagikan Artikel
                            </button>
                        </div>
                    </section>

                    <section v-if="blog_ad?.image" class="bg-white border border-gray-300 rounded-4 mt-6 overflow-hidden">
                        <a v-if="blog_ad.link" :href="blog_ad.link" target="_blank"
                            class="blog-detail-ad-link d-block" :aria-label="blog_ad.description || 'Iklan Blog'">
                            <img :src="imageUrl(blog_ad.image)" :alt="blog_ad.description || 'Iklan Blog'"
                                class="blog-detail-ad-image">
                        </a>
                        <img v-else :src="imageUrl(blog_ad.image)" :alt="blog_ad.description || 'Iklan Blog'"
                            class="blog-detail-ad-image">
                    </section>

                    <!-- <Link href="/blogs"
                        class="btn btn-myprimary-filled btn-hover-icon rounded-3 fw-bolder fs-5 d-flex align-items-center justify-content-center gap-1 mt-6">
                        Lihat Semua Blog
                        <i class="ri-arrow-right-up-line fs-3 me-n2"></i>
                    </Link> -->
                </aside>
            </div>

            <section v-if="shouldShowRelatedBlogs" class="mt-14 mt-md-16">
                <div class="d-flex flex-column flex-md-row gap-5 align-items-md-end justify-content-md-between mb-8">
                    <div>
                        <h2 class="text-dark fw-bolder fs-2x mb-3">Blog Lainnya</h2>
                        <p class="text-gray-600 fs-5 fw-semibold mb-0">
                            Lanjutkan membaca blog lain yang masih relevan.
                        </p>
                    </div>
                    <Link href="/blogs"
                        class="btn btn-sm btn-hover-icon btn-myprimary-tinted rounded-3 fw-bolder fs-5 d-inline-flex align-items-center justify-content-center gap-1">
                        Semua Blog
                        <i class="ri-arrow-right-up-line fs-3 me-n2"></i>
                    </Link>
                </div>

                <div class="blog-detail-related-grid">
                    <Link v-for="relatedBlog in relatedBlogItems" :key="relatedBlog.id"
                        :href="`/blogs/${relatedBlog.slug}`"
                        class="blog-detail-related-card d-flex flex-column bg-white rounded-4 p-2 border border-gray-300 h-100 text-decoration-none">
                        <div v-if="relatedBlog.image" class="ratio ratio-4x3 rounded-3 overflow-hidden">
                            <img :src="imageUrl(relatedBlog.image)" :alt="relatedBlog.title"
                                class="blog-detail-related-card-image">
                        </div>
                        <div class="p-6 pt-8 d-flex flex-column flex-grow-1">
                            <h3 class="text-dark fw-bolder text-truncate-2 fs-2 mb-3">
                                {{ relatedBlog.title }}
                            </h3>
                            <p class="text-gray-600 fs-5 fw-semibold mb-0">
                                {{ formatDate(relatedBlog.created_at) }}
                            </p>
                        </div>
                    </Link>
                </div>
            </section>
        </section>
    </LayoutUser>
</template>

<script>
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import LayoutUser from '../../../Layouts/User.vue';

export default {
    components: {
        Head,
        Link,
        LayoutUser,
    },

    props: {
        blog: {
            type: Object,
            required: true,
        },
        related_blogs: {
            type: Array,
            default: () => [],
        },
        blog_ad: {
            type: Object,
            default: null,
        },
        setting: {
            type: Object,
            default: () => ({}),
        },
        description: {
            type: String,
            default: '',
        },
        current_url: {
            type: String,
            default: '',
        },
        app_url: {
            type: String,
            default: '',
        },
    },

    setup(props) {
        const copyLabel = ref('Salin Link');
        const safeRelatedBlogs = computed(() => props.related_blogs || []);
        const shouldShowRelatedBlogs = computed(() => safeRelatedBlogs.value.length >= 3);
        const relatedBlogItems = computed(() => safeRelatedBlogs.value.slice(0, 3));
        const pageTitle = computed(() => `${props.blog.title} - ${props.setting?.site_title || 'Pustaka Riyadz'}`);
        const blogAuthorName = computed(() => props.blog.author?.name || props.blog.author || '');
        const imageUrl = (path) => {
            if (!path) {
                return '';
            }

            if (/^https?:\/\//i.test(path)) {
                return path;
            }

            if (path.startsWith('/')) {
                return path;
            }

            return `/storage/${path.replace(/^storage\//, '')}`;
        };
        const absoluteImageUrl = (path) => {
            const url = imageUrl(path);

            if (!url) {
                return '';
            }

            if (/^https?:\/\//i.test(url)) {
                return url;
            }

            return `${props.app_url}${url}`;
        };
        const blogImageUrl = computed(() => absoluteImageUrl(props.blog.image));
        const shareUrl = computed(() => {
            if (props.current_url) {
                return props.current_url;
            }

            if (typeof window !== 'undefined') {
                return window.location.href;
            }

            return `/blogs/${props.blog.slug}`;
        });
        const shareText = computed(() => props.description || props.blog.excerpt || props.blog.title);
        const encodedShareUrl = computed(() => encodeURIComponent(shareUrl.value));
        const encodedShareText = computed(() => encodeURIComponent(`${props.blog.title} - ${shareUrl.value}`));
        const whatsappShareUrl = computed(() => `https://wa.me/?text=${encodedShareText.value}`);
        const facebookShareUrl = computed(() => `https://www.facebook.com/sharer/sharer.php?u=${encodedShareUrl.value}`);
        const twitterShareUrl = computed(() => `https://twitter.com/intent/tweet?text=${encodeURIComponent(props.blog.title)}&url=${encodedShareUrl.value}`);

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

        const formatViews = (views) => {
            const total = Number(views || 0);
            return `${new Intl.NumberFormat('id-ID').format(total)}x dilihat`;
        };

        const goBack = () => {
            if (window.history.length > 1) {
                window.history.back();
                return;
            }

            router.visit('/blogs');
        };

        const copyShareLink = async () => {
            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(shareUrl.value);
                } else {
                    const textArea = document.createElement('textarea');
                    textArea.value = shareUrl.value;
                    textArea.setAttribute('readonly', '');
                    textArea.style.position = 'fixed';
                    textArea.style.opacity = '0';
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                }

                copyLabel.value = 'Tersalin';
                window.setTimeout(() => {
                    copyLabel.value = 'Salin Link';
                }, 1800);
            } catch (error) {
                copyLabel.value = 'Gagal Disalin';
                window.setTimeout(() => {
                    copyLabel.value = 'Salin Link';
                }, 1800);
            }
        };

        const shareArticle = async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: props.blog.title,
                        text: shareText.value,
                        url: shareUrl.value,
                    });
                    return;
                } catch (error) {
                    if (error?.name === 'AbortError') {
                        return;
                    }
                }
            }

            copyShareLink();
        };

        return {
            copyLabel,
            safeRelatedBlogs,
            shouldShowRelatedBlogs,
            relatedBlogItems,
            pageTitle,
            blogAuthorName,
            blogImageUrl,
            shareUrl,
            whatsappShareUrl,
            facebookShareUrl,
            twitterShareUrl,
            imageUrl,
            formatDate,
            formatViews,
            goBack,
            copyShareLink,
            shareArticle,
        };
    },
};
</script>

<style scoped>
.blog-detail-page {
    padding-bottom: 10rem;
}

.blog-detail-hero {
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.05);
}

.blog-detail-cover {
    aspect-ratio: 4 / 3;
    background: #ffffff;
    overflow: hidden;
}

.blog-detail-cover-image {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.blog-detail-chip {
    display: inline-flex;
    align-items: center;
    min-height: 34px;
    border: 1px solid rgba(249, 115, 22, 0.14);
    border-radius: 999px;
    background: #fff7ed;
    color: var(--base-color-700);
    padding: 0.45rem 0.85rem;
    font-size: 0.78rem;
    font-weight: 800;
}

.blog-detail-chip-muted {
    border-color: rgba(100, 116, 139, 0.14);
    background: #f1f5f9;
    color: #64748b;
}

.blog-detail-excerpt {
    max-width: 840px;
}

.blog-detail-content {
    max-width: 100%;
    overflow-wrap: anywhere;
}

.blog-detail-content :deep(p:first-child) {
    margin-top: 0;
}

.blog-detail-content :deep(p:last-child) {
    margin-bottom: 0;
}

.blog-detail-content :deep(img) {
    display: block;
    margin: 1.5rem auto;
    border: 1px solid var(--bs-gray-300);
}

.blog-detail-content :deep(table) {
    width: 100%;
    margin: 1.75rem 0;
    border-collapse: collapse;
    overflow: hidden;
    border: 1px solid var(--bs-gray-300);
    border-radius: 0.75rem;
}

.blog-detail-content :deep(th),
.blog-detail-content :deep(td) {
    border: 1px solid var(--bs-gray-300);
    padding: 0.85rem 1rem;
    vertical-align: top;
}

.blog-detail-content :deep(th) {
    background: #f8fafc;
    color: var(--slate-900);
    font-weight: 800;
}

.blog-detail-sidebar {
    position: sticky;
    top: 128px;
}

.blog-detail-sidebar-icon {
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

.blog-share-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
}

.blog-detail-ad-image {
    width: 100%;
    display: block;
    object-fit: cover;
    transition: transform 0.2s ease;
}

.blog-detail-ad-link:hover .blog-detail-ad-image {
    transform: scale(1.02);
}

.blog-share-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 0;
    height: 46px;
    border: 1px solid rgba(249, 115, 22, 0.18);
    border-radius: 0.65rem;
    background: #fff7ed;
    color: var(--base-color-700);
    transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.blog-share-button:hover {
    background: var(--base-color-500);
    color: #ffffff;
    transform: translateY(-1px);
}

.blog-detail-related-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.75rem;
}

.blog-detail-related-card {
    min-width: 0;
    color: inherit;
}

.blog-detail-related-card-image {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

@media (max-width: 991.98px) {
    .blog-detail-sidebar {
        position: static;
    }

    .blog-detail-cover {
        aspect-ratio: 4 / 3;
    }

    .blog-detail-related-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575.98px) {
    .blog-detail-page {
        padding-bottom: 7.5rem;
    }

    .blog-detail-cover {
        aspect-ratio: 4 / 3;
    }

    .blog-detail-chip {
        width: 100%;
        justify-content: center;
    }

    .blog-detail-related-grid {
        grid-template-columns: 1fr;
    }
}
</style>
