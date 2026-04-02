@extends('layouts.app')

@section('title', 'NusaMart – Marketplace Produk UMKM Lokal')

@push('styles')
<style>
/* ===== HERO BANNER ===== */
.hero-section {
    background: linear-gradient(135deg, #15161d 0%, #1a1b2e 50%, #1e0010 100%);
    padding: 50px 0 60px;
    position: relative;
    overflow: hidden;
}
.hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(209,0,36,0.15) 0%, transparent 60%),
                radial-gradient(ellipse at 20% 80%, rgba(70,0,150,0.10) 0%, transparent 50%);
    pointer-events: none;
}
.hero-inner {
    display: flex;
    align-items: center;
    gap: 40px;
}
.hero-text { flex: 1; color: #fff; }
.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(209,0,36,0.15);
    border: 1px solid rgba(209,0,36,0.35);
    color: #ff4d6d;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 5px 14px;
    border-radius: 50px;
    margin-bottom: 18px;
}
.hero-title {
    font-size: 42px;
    font-weight: 800;
    line-height: 1.15;
    margin-bottom: 16px;
}
.hero-title span { color: #D10024; }
.hero-subtitle {
    color: #b9babc;
    font-size: 15px;
    line-height: 1.7;
    margin-bottom: 28px;
    max-width: 460px;
}
.hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.btn-hero-primary {
    background: #D10024;
    color: #fff;
    border: none;
    padding: 14px 28px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 20px rgba(209,0,36,0.35);
}
.btn-hero-primary:hover {
    background: #a8001d;
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(209,0,36,0.45);
    color: #fff;
}
.btn-hero-secondary {
    background: rgba(255,255,255,0.08);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.18);
    padding: 14px 28px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s, transform 0.2s;
}
.btn-hero-secondary:hover {
    background: rgba(255,255,255,0.14);
    transform: translateY(-2px);
    color: #fff;
}
.hero-stats {
    display: flex;
    gap: 30px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid rgba(255,255,255,0.08);
}
.hero-stat-item { text-align: left; }
.hero-stat-number {
    font-size: 24px;
    font-weight: 800;
    color: #fff;
    display: block;
}
.hero-stat-label {
    font-size: 11px;
    color: #8d8e9a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.hero-visual {
    flex: 0 0 460px;
    position: relative;
}
.hero-cards-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.hero-product-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 14px;
    overflow: hidden;
    transition: transform 0.3s;
    cursor: pointer;
}
.hero-product-card:hover { transform: translateY(-4px); }
.hero-product-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}
.hero-product-info {
    padding: 10px 12px 12px;
}
.hero-product-info .name {
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.hero-product-info .price {
    color: #ff4d6d;
    font-size: 13px;
    font-weight: 700;
}
@media (max-width: 992px) {
    .hero-visual { display: none; }
    .hero-title { font-size: 30px; }
}

/* ===== SEARCH BAR (guest) ===== */
.home-search-bar {
    background: #fff;
    padding: 16px 0;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    position: sticky;
    top: 0;
    z-index: 100;
}
.home-search-inner {
    display: flex;
    gap: 10px;
    align-items: center;
}
.home-search-inner select {
    padding: 10px 14px;
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    font-family: inherit;
    font-size: 13px;
    color: #555;
    background: #fafafa;
    cursor: pointer;
    min-width: 140px;
}
.home-search-inner input {
    flex: 1;
    padding: 10px 16px;
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    font-family: inherit;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}
.home-search-inner input:focus { border-color: #D10024; }
.home-search-btn {
    background: #D10024;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 7px;
    transition: background 0.2s;
}
.home-search-btn:hover { background: #a8001d; }

/* ===== PROMO STRIP ===== */
.promo-strip {
    background: linear-gradient(90deg, #D10024, #a8001d);
    padding: 10px 0;
    overflow: hidden;
}
.promo-strip-inner {
    display: flex;
    gap: 60px;
    align-items: center;
    white-space: nowrap;
    animation: marquee 30s linear infinite;
}
.promo-strip-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    flex-shrink: 0;
}
.promo-strip-item .fa { font-size: 15px; }
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* ===== CATEGORY SECTION ===== */
.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
}
.section-title {
    font-size: 22px;
    font-weight: 800;
    color: #1a1b28;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 24px;
    background: #D10024;
    border-radius: 4px;
}
.section-view-all {
    font-size: 13px;
    color: #D10024;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: gap 0.2s;
}
.section-view-all:hover { gap: 10px; color: #a8001d; }

/* ===== BURGER MENU CATEGORY ===== */
.burger-menu-btn {
    display: none;
    background: #D10024;
    color: #fff;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.2s;
}
.burger-menu-btn:hover { background: #a8001d; }
.burger-menu-btn.active { background: #a8001d; }

.categories-top-bar {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
}
.categories-section-title {
    font-size: 22px;
    font-weight: 800;
    color: #1a1b28;
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}
.categories-section-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 24px;
    background: #D10024;
    border-radius: 4px;
}

.categories-dropdown-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: none;
    z-index: 998;
}
.categories-dropdown-overlay.active { display: block; }

.categories-dropdown-menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: #fff;
    box-shadow: 2px 0 20px rgba(0,0,0,0.1);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    z-index: 999;
    overflow-y: auto;
    padding-bottom: 20px;
}
.categories-dropdown-menu.active { transform: translateX(0); }

.dropdown-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    border-bottom: 1px solid #f0f0f0;
    background: #f9f9f9;
    position: sticky;
    top: 0;
}
.dropdown-menu-title {
    font-size: 16px;
    font-weight: 700;
    color: #333;
}
.dropdown-close-btn {
    background: none;
    border: none;
    font-size: 24px;
    color: #666;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}
.dropdown-close-btn:hover { color: #333; }

.dropdown-category-list {
    display: flex;
    flex-direction: column;
    gap: 0;
    padding: 12px 0;
}
.dropdown-category-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    color: #444;
    border-left: 4px solid transparent;
}
.dropdown-category-item:hover {
    background: #f9f9f9;
    border-left-color: #D10024;
}
.dropdown-category-item.active {
    background: rgba(209,0,36,0.08);
    border-left-color: #D10024;
    color: #D10024;
    font-weight: 600;
}
.dropdown-category-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #fff;
    flex-shrink: 0;
}
.dropdown-category-name {
    font-size: 14px;
    font-weight: 600;
}

.categories-section { padding: 36px 0 20px; }
.categories-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 12px;
}
.category-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s;
    border: 1.5px solid #f0f0f0;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    border-color: #D10024;
}
.category-card.active {
    background: rgba(209,0,36,0.05);
    border-color: #D10024;
    box-shadow: 0 4px 16px rgba(209,0,36,0.15);
}
.category-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
    flex-shrink: 0;
}
.category-name {
    font-size: 11px;
    font-weight: 700;
    color: #444;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
@media (max-width: 768px) {
    .categories-grid { grid-template-columns: repeat(4, 1fr); }
    .burger-menu-btn { display: flex; }
    .categories-grid { display: none; }
}
@media (max-width: 480px) {
    .categories-grid { grid-template-columns: repeat(3, 1fr); }
    .categories-dropdown-menu { width: 250px; }
}

/* ===== PRODUCT SECTION ===== */
.products-section { padding: 30px 0 20px; }
.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}
.product-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1.5px solid #f0f0f0;
    transition: all 0.25s;
    cursor: pointer;
    position: relative;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    border-color: rgba(209,0,36,0.2);
}
.product-img-wrap {
    position: relative;
    overflow: hidden;
    background: #f6f6f6;
    height: 200px;
}
.product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
}
.product-card:hover .product-img-wrap img { transform: scale(1.06); }
.product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 3px 10px;
    border-radius: 50px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.badge-terlaris { background: #D10024; color: #fff; }
.badge-pilihan  { background: #9b59b6; color: #fff; }
.badge-diskon   { background: #e67e22; color: #fff; }
.badge-baru     { background: #27ae60; color: #fff; }
.product-wishlist {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
    color: #bbb;
    transition: color 0.2s, background 0.2s;
    opacity: 0;
    transition: all 0.2s;
}
.product-card:hover .product-wishlist { opacity: 1; }
.product-wishlist:hover { color: #D10024; background: #fff; }
.product-info { padding: 14px; }
.product-category-tag {
    font-size: 10px;
    color: #D10024;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}
.product-name {
    font-size: 13.5px;
    font-weight: 700;
    color: #222;
    line-height: 1.4;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.product-price-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}
.product-price {
    font-size: 16px;
    font-weight: 800;
    color: #D10024;
}
.product-original-price {
    font-size: 12px;
    color: #bbb;
    text-decoration: line-through;
}
.product-discount {
    background: #fff0f0;
    color: #D10024;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
}
.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 8px;
    border-top: 1px solid #f0f0f0;
    margin-top: 6px;
}
.product-seller {
    font-size: 11px;
    color: #888;
    display: flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 55%;
}
.product-rating {
    font-size: 11px;
    color: #f39c12;
    display: flex;
    align-items: center;
    gap: 3px;
    white-space: nowrap;
}
.product-rating span { color: #888; }
@media (max-width: 992px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .products-grid { grid-template-columns: 1fr 1fr; gap: 10px; } }

/* ===== FLASH SALE SECTION ===== */
.flash-sale-section {
    background: linear-gradient(135deg, #1a1b2e, #15161d);
    padding: 30px 0;
    margin: 10px 0;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
}
.flash-sale-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 0% 50%, rgba(209,0,36,0.15) 0%, transparent 50%);
    pointer-events: none;
}
.flash-sale-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 0 24px;
}
.flash-sale-title {
    display: flex;
    align-items: center;
    gap: 14px;
    color: #fff;
    font-size: 20px;
    font-weight: 800;
}
.flash-icon {
    background: #D10024;
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 16px;
    animation: pulse-glow 2s infinite;
}
.flash-countdown {
    display: flex;
    gap: 8px;
    align-items: center;
}
.countdown-block {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 8px;
    width: 44px;
    height: 44px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.countdown-num {
    font-size: 16px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.countdown-label {
    font-size: 9px;
    color: #888;
    text-transform: uppercase;
}
.countdown-sep {
    color: #D10024;
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 6px;
}
.flash-sale-scroll {
    overflow-x: auto;
    padding: 0 24px 8px;
    scrollbar-width: none;
}
.flash-sale-scroll::-webkit-scrollbar { display: none; }
.flash-products-row {
    display: flex;
    gap: 14px;
    width: max-content;
}
.flash-product-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 14px;
    overflow: hidden;
    width: 160px;
    transition: transform 0.25s;
    cursor: pointer;
    flex-shrink: 0;
}
.flash-product-card:hover { transform: translateY(-4px); }
.flash-product-card img { width: 100%; height: 130px; object-fit: cover; }
.flash-product-info { padding: 10px; }
.flash-product-name {
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.flash-price-row { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.flash-price { color: #ff4d6d; font-size: 14px; font-weight: 800; }
.flash-original { color: #666; font-size: 11px; text-decoration: line-through; }
.flash-disc {
    background: #D10024;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
}
.flash-progress { margin-top: 8px; }
.flash-progress-bar {
    height: 5px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    overflow: hidden;
}
.flash-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #D10024, #ff6b6b);
    border-radius: 10px;
}
.flash-progress-text {
    font-size: 10px;
    color: #888;
    margin-top: 3px;
}

/* ===== SELLERS SECTION ===== */
.sellers-section { padding: 30px 0; }
.sellers-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}
.seller-card {
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 16px;
    padding: 24px 18px;
    text-align: center;
    transition: all 0.25s;
    cursor: pointer;
    text-decoration: none;
}
.seller-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.10);
    border-color: rgba(209,0,36,0.2);
}
.seller-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    margin: 0 auto 12px;
    overflow: hidden;
    border: 3px solid #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
}
.seller-avatar img { width: 100%; height: 100%; object-fit: cover; }
.seller-name {
    font-size: 14px;
    font-weight: 700;
    color: #222;
    margin-bottom: 4px;
}
.seller-category {
    font-size: 11px;
    color: #888;
    margin-bottom: 10px;
}
.seller-stats {
    display: flex;
    justify-content: center;
    gap: 16px;
    padding-top: 10px;
    border-top: 1px solid #f0f0f0;
}
.seller-stat { text-align: center; }
.seller-stat-num {
    font-size: 15px;
    font-weight: 800;
    color: #222;
    display: block;
}
.seller-stat-label {
    font-size: 10px;
    color: #aaa;
    text-transform: uppercase;
}
@media (max-width: 768px) {
    .sellers-grid { grid-template-columns: repeat(2, 1fr); }
}

/* ===== TRUST BADGES ===== */
.trust-section {
    background: #fff;
    padding: 28px 0;
    margin-top: 10px;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
}
.trust-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}
.trust-item {
    display: flex;
    align-items: center;
    gap: 14px;
}
.trust-icon-wrap {
    width: 46px;
    height: 46px;
    background: #fff0f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #D10024;
    flex-shrink: 0;
}
.trust-text-title {
    font-size: 13px;
    font-weight: 700;
    color: #222;
    margin-bottom: 2px;
}
.trust-text-sub { font-size: 11px; color: #888; }
@media (max-width: 768px) {
    .trust-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .trust-grid { grid-template-columns: 1fr; }
}

/* ===== BANNER PROMO GRID ===== */
.promo-banner-section { padding: 24px 0; }
.promo-banner-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 16px;
    align-items: stretch;
}
.promo-banner-card {
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    min-height: 180px;
    display: flex;
    align-items: flex-end;
    cursor: pointer;
    text-decoration: none;
}
.promo-banner-card img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
}
.promo-banner-card:hover img { transform: scale(1.05); }
.promo-banner-overlay {
    position: relative;
    z-index: 2;
    padding: 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 100%);
    width: 100%;
}
.promo-banner-tag {
    font-size: 10px;
    font-weight: 700;
    color: #ff4d6d;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}
.promo-banner-title {
    font-size: 18px;
    font-weight: 800;
    color: #fff;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}
.promo-banner-sub { font-size: 13px; color: rgba(255,255,255,0.8); }
@media (max-width: 768px) {
    .promo-banner-grid { grid-template-columns: 1fr; }
}

/* ===== NEWSLETTER ===== */
.newsletter-section {
    background: linear-gradient(135deg, #15161d, #1a1b2e);
    padding: 48px 0;
    margin-top: 10px;
}
.newsletter-inner {
    display: flex;
    align-items: center;
    gap: 40px;
}
.newsletter-text { flex: 1; color: #fff; }
.newsletter-text h2 { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
.newsletter-text h2 span { color: #ff4d6d; }
.newsletter-text p { color: #8d8e9a; font-size: 14px; }
.newsletter-form { display: flex; gap: 10px; flex: 0 0 400px; }
.newsletter-form input {
    flex: 1;
    padding: 12px 16px;
    border: 1.5px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.07);
    border-radius: 10px;
    color: #fff;
    font-family: inherit;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}
.newsletter-form input::placeholder { color: #666; }
.newsletter-form input:focus { border-color: #D10024; }
.newsletter-form button {
    background: #D10024;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    white-space: nowrap;
}
.newsletter-form button:hover { background: #a8001d; }
@media (max-width: 768px) {
    .newsletter-inner { flex-direction: column; }
    .newsletter-form { flex: 0 0 auto; width: 100%; }
}

/* ===== MAIN WRAPPER ===== */
.home-wrapper { background: #f0f1f5; }
.home-content-area { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
</style>
@endpush

@section('content')
<div class="home-wrapper">

    {{-- ===== HERO ===== --}}
    <section class="hero-section">
        <div class="container">
            <div class="hero-inner">
                <div class="hero-text">
                    <div class="hero-eyebrow">
                        <i class="fa fa-star"></i>
                        Marketplace Produk UMKM Lokal #1
                    </div>
                    <h1 class="hero-title">
                        Temukan Produk <span>UMKM Terbaik</span><br>
                        dari Nusantara
                    </h1>
                    <p class="hero-subtitle">
                        Belanja langsung dari pengrajin &amp; pedagang UMKM lokal. Ribuan produk
                        autentik berkualitas — makanan, fashion, kerajinan &amp; lebih banyak lagi.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn-hero-primary">
                            <i class="fa fa-shopping-bag"></i> Mulai Belanja
                        </a>
                        <a href="{{ route('page.tentang') }}" class="btn-hero-secondary">
                            <i class="fa fa-info-circle"></i> Tentang NusaMart
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <span class="hero-stat-number">500+</span>
                            <span class="hero-stat-label">Produk UMKM</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="hero-stat-number">120+</span>
                            <span class="hero-stat-label">Penjual Aktif</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="hero-stat-number">10rb+</span>
                            <span class="hero-stat-label">Transaksi & Senang</span>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="hero-cards-grid">
                        @foreach(array_slice($featuredProducts, 0, 4) as $p)
                        <div class="hero-product-card">
                            <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}">
                            <div class="hero-product-info">
                                <div class="name">{{ $p['name'] }}</div>
                                <div class="price">Rp {{ number_format($p['price'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== PROMO STRIP ===== --}}
    <div class="promo-strip">
        <div class="promo-strip-inner">
            <span class="promo-strip-item"><i class="fa fa-truck"></i> Gratis Ongkir min. Rp 100.000</span>
            <span class="promo-strip-item"><i class="fa fa-shield"></i> Pembayaran 100% Aman</span>
            <span class="promo-strip-item"><i class="fa fa-refresh"></i> Garansi Pengembalian 7 Hari</span>
            <span class="promo-strip-item"><i class="fa fa-star"></i> Produk Asli UMKM Lokal</span>
            <span class="promo-strip-item"><i class="fa fa-headphones"></i> Layanan CS 24 Jam</span>
            {{-- Duplikat untuk efek marquee --}}
            <span class="promo-strip-item"><i class="fa fa-truck"></i> Gratis Ongkir min. Rp 100.000</span>
            <span class="promo-strip-item"><i class="fa fa-shield"></i> Pembayaran 100% Aman</span>
            <span class="promo-strip-item"><i class="fa fa-refresh"></i> Garansi Pengembalian 7 Hari</span>
            <span class="promo-strip-item"><i class="fa fa-star"></i> Produk Asli UMKM Lokal</span>
            <span class="promo-strip-item"><i class="fa fa-headphones"></i> Layanan CS 24 Jam</span>
        </div>
    </div>

    {{-- ===== SEARCH BAR (hanya untuk guest) ===== --}}
    @guest
    <div class="home-search-bar">
        <div class="container">
            <div class="home-search-inner">
                <select>
                    <option>Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option>{{ $cat['name'] }}</option>
                    @endforeach
                </select>
                <input type="text" placeholder="Cari produk UMKM favoritmu...">
                <button class="home-search-btn">
                    <i class="fa fa-search"></i> Cari
                </button>
            </div>
        </div>
    </div>
    @endguest

    <div class="home-content-area">

        {{-- ===== KATEGORI ===== --}}
        <section class="categories-section">
            <div class="categories-top-bar">
                <button class="burger-menu-btn" id="categoryBurgerBtn" title="Buka Menu Kategori">
                    <i class="fa fa-bars"></i>
                </button>
                <h2 class="categories-section-title">Kategori Produk</h2>
                <a href="#" class="section-view-all">Lihat Semua <i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="categories-grid">
                @foreach($categories as $cat)
                <a href="#" class="category-card" data-category="{{ $cat['slug'] }}" onclick="filterByCategory(this); return false;">
                    <div class="category-icon" style="background: {{ $cat['color'] }};">
                        <i class="fa {{ $cat['icon'] }}"></i>
                    </div>
                    <span class="category-name">{{ $cat['name'] }}</span>
                </a>
                @endforeach
            </div>
        </section>

        {{-- ===== CATEGORIES DROPDOWN MENU ===== --}}
        <div class="categories-dropdown-overlay" id="categoryDropdownOverlay"></div>
        <div class="categories-dropdown-menu" id="categoryDropdownMenu">
            <div class="dropdown-menu-header">
                <h3 class="dropdown-menu-title">Kategori</h3>
                <button class="dropdown-close-btn" id="closeDropdownBtn">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="dropdown-category-list">
                <a href="#" class="dropdown-category-item" data-category="all" onclick="filterByCategory(null, 'all'); return false;">
                    <div class="dropdown-category-icon" style="background: #666;">
                        <i class="fa fa-th"></i>
                    </div>
                    <span class="dropdown-category-name">Semua Kategori</span>
                </a>
                @foreach($categories as $cat)
                <a href="#" class="dropdown-category-item" data-category="{{ $cat['slug'] }}" onclick="filterByCategory(this); return false;">
                    <div class="dropdown-category-icon" style="background: {{ $cat['color'] }};">
                        <i class="fa {{ $cat['icon'] }}"></i>
                    </div>
                    <span class="dropdown-category-name">{{ $cat['name'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- ===== PROMO BANNER ===== --}}
        <section class="promo-banner-section">
            <div class="promo-banner-grid">
                <a href="{{ route('login') }}" class="promo-banner-card" style="min-height:200px">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80" alt="Promo Utama">
                    <div class="promo-banner-overlay">
                        <div class="promo-banner-tag"><i class="fa fa-bolt"></i> Flash Sale Hari Ini</div>
                        <div class="promo-banner-title">Diskon s/d 50%</div>
                        <div class="promo-banner-sub">Produk pilihan UMKM unggulan</div>
                    </div>
                </a>
                <a href="{{ route('login') }}" class="promo-banner-card">
                    <img src="https://images.unsplash.com/photo-1511690656952-34342bb7c2f2?w=400&q=80" alt="Kerajinan">
                    <div class="promo-banner-overlay">
                        <div class="promo-banner-tag">Kerajinan</div>
                        <div class="promo-banner-title">Handmade Lokal</div>
                    </div>
                </a>
                <a href="{{ route('login') }}" class="promo-banner-card">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&q=80" alt="Fashion">
                    <div class="promo-banner-overlay">
                        <div class="promo-banner-tag">Fashion</div>
                        <div class="promo-banner-title">Batik & Tenun</div>
                    </div>
                </a>
            </div>
        </section>

        {{-- ===== FLASH SALE ===== --}}
        <section class="flash-sale-section">
            <div class="flash-sale-header">
                <div class="flash-sale-title">
                    <span class="flash-icon"><i class="fa fa-bolt"></i></span>
                    Flash Sale
                </div>
                <div class="flash-countdown">
                    <span style="color:#888;font-size:12px;margin-right:4px;">Berakhir dalam:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-h">05</span>
                        <span class="countdown-label">jam</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-m">42</span>
                        <span class="countdown-label">mnt</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-s">18</span>
                        <span class="countdown-label">dtk</span>
                    </div>
                </div>
            </div>
            <div class="flash-sale-scroll">
                <div class="flash-products-row">
                    @foreach($featuredProducts as $p)
                    @if($p['original_price'] > $p['price'])
                    <div class="flash-product-card">
                        <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}">
                        <div class="flash-product-info">
                            <div class="flash-product-name">{{ $p['name'] }}</div>
                            <div class="flash-price-row">
                                <span class="flash-price">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                                <span class="flash-original">Rp {{ number_format($p['original_price'], 0, ',', '.') }}</span>
                                <span class="flash-disc">{{ round((1 - $p['price']/$p['original_price']) * 100) }}%</span>
                            </div>
                            <div class="flash-progress">
                                <div class="flash-progress-bar">
                                    <div class="flash-progress-fill" style="width: {{ min(100, ($p['sold'] / 300) * 100) }}%"></div>
                                </div>
                                <div class="flash-progress-text">Terjual {{ $p['sold'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===== PRODUK UNGGULAN ===== --}}
        <section class="products-section">
            <div class="section-header">
                <h2 class="section-title">Produk Unggulan UMKM</h2>
                <a href="{{ route('login') }}" class="section-view-all">Lihat Semua <i class="fa fa-arrow-right"></i></a>
            </div>
        {{-- ===== PRODUK UNGGULAN ===== --}}
        <section class="products-section">
            <div class="section-header">
                <h2 class="section-title">Produk Unggulan UMKM</h2>
                <a href="{{ route('login') }}" class="section-view-all">Lihat Semua <i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="products-grid">
                @foreach($featuredProducts as $product)
                <div class="product-card" data-category="{{ strtolower(str_replace(' ', '-', $product['category'])) }}">
                    <div class="product-img-wrap">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                        @if($product['badge'])
                        <span class="product-badge badge-{{ strtolower($product['badge']) }}">{{ $product['badge'] }}</span>
                        @endif
                        <button class="product-wishlist"><i class="fa fa-heart-o"></i></button>
                    </div>
                    <div class="product-info">
                        <div class="product-category-tag">{{ $product['category'] }}</div>
                        <div class="product-name">{{ $product['name'] }}</div>
                        <div class="product-price-row">
                            <span class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                            @if($product['original_price'] > $product['price'])
                            <span class="product-original-price">Rp {{ number_format($product['original_price'], 0, ',', '.') }}</span>
                            <span class="product-discount">{{ round((1 - $product['price']/$product['original_price']) * 100) }}%</span>
                            @endif
                        </div>
                        <div class="product-footer">
                            <span class="product-seller"><i class="fa fa-store"></i> {{ $product['seller'] }}</span>
                            <span class="product-rating">
                                <i class="fa fa-star"></i>
                                {{ $product['rating'] }}
                                <span>({{ $product['sold'] }})</span>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        </section>

        {{-- ===== PENJUAL UMKM ===== --}}
        <section class="sellers-section">
            <div class="section-header">
                <h2 class="section-title">Toko UMKM Terpercaya</h2>
                <a href="{{ route('login') }}" class="section-view-all">Lihat Semua <i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="sellers-grid">
                @foreach($sellers as $seller)
                <a href="{{ route('login') }}" class="seller-card">
                    <div class="seller-avatar">
                        <img src="{{ $seller['image'] }}" alt="{{ $seller['name'] }}">
                    </div>
                    <div class="seller-name">{{ $seller['name'] }}</div>
                    <div class="seller-category">{{ $seller['category'] }}</div>
                    <div class="seller-stats">
                        <div class="seller-stat">
                            <span class="seller-stat-num">{{ $seller['products'] }}</span>
                            <span class="seller-stat-label">Produk</span>
                        </div>
                        <div class="seller-stat">
                            <span class="seller-stat-num" style="color:#f39c12"><i class="fa fa-star"></i> {{ $seller['rating'] }}</span>
                            <span class="seller-stat-label">Rating</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        {{-- ===== PRODUK BARU ===== --}}
        <section class="products-section">
            <div class="section-header">
                <h2 class="section-title">Produk Terbaru</h2>
                <a href="{{ route('login') }}" class="section-view-all">Lihat Semua <i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="products-grid">
                @foreach($newProducts as $product)
                <div class="product-card" data-category="{{ strtolower(str_replace(' ', '-', $product['category'])) }}">
                    <div class="product-img-wrap">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                        <span class="product-badge badge-baru">Baru</span>
                        <button class="product-wishlist"><i class="fa fa-heart-o"></i></button>
                    </div>
                    <div class="product-info">
                        <div class="product-category-tag">{{ $product['category'] }}</div>
                        <div class="product-name">{{ $product['name'] }}</div>
                        <div class="product-price-row">
                            <span class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="product-footer">
                            <span class="product-seller"><i class="fa fa-store"></i> {{ $product['seller'] }}</span>
                            <span class="product-rating">
                                <i class="fa fa-star"></i>
                                {{ $product['rating'] }}
                                <span>({{ $product['sold'] }})</span>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

    </div>{{-- /home-content-area --}}

    {{-- ===== TRUST BADGES ===== --}}
    <div class="trust-section">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-truck"></i></div>
                    <div>
                        <div class="trust-text-title">Gratis Ongkos Kirim</div>
                        <div class="trust-text-sub">Untuk pembelian min. Rp 100.000</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-shield"></i></div>
                    <div>
                        <div class="trust-text-title">Transaksi Aman</div>
                        <div class="trust-text-sub">Pembayaran terenkripsi & terjamin</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-refresh"></i></div>
                    <div>
                        <div class="trust-text-title">Pengembalian Mudah</div>
                        <div class="trust-text-sub">Garansi 7 hari jika tidak sesuai</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon-wrap"><i class="fa fa-headphones"></i></div>
                    <div>
                        <div class="trust-text-title">Layanan 24/7</div>
                        <div class="trust-text-sub">Customer service siap membantu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== NEWSLETTER ===== --}}
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-inner">
                <div class="newsletter-text">
                    <h2>Dapatkan <span>Promo Eksklusif</span> Produk UMKM</h2>
                    <p>Daftarkan email kamu dan jadilah yang pertama tahu penawaran terbaru, produk baru, dan diskon spesial dari NusaMart.</p>
                </div>
                <div class="newsletter-form">
                    <input type="email" placeholder="Masukkan alamat email kamu...">
                    <button type="button"><i class="fa fa-envelope-o"></i> Daftar</button>
                </div>
            </div>
        </div>
    </section>

</div>{{-- /home-wrapper --}}
@endsection

@push('scripts')
<script>
// Countdown Timer
(function() {
    var deadline = new Date();
    deadline.setHours(deadline.getHours() + 5, deadline.getMinutes() + 42, deadline.getSeconds() + 18);

    function pad(n) { return n < 10 ? '0' + n : n; }
    function updateCountdown() {
        var now = new Date();
        var diff = Math.max(0, deadline - now);
        var h = Math.floor(diff / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        var hEl = document.getElementById('cd-h');
        var mEl = document.getElementById('cd-m');
        var sEl = document.getElementById('cd-s');
        if (hEl) hEl.textContent = pad(h);
        if (mEl) mEl.textContent = pad(m);
        if (sEl) sEl.textContent = pad(s);
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
})();

// Burger Menu & Category Filter
(function() {
    var burgerBtn = document.getElementById('categoryBurgerBtn');
    var dropdown = document.getElementById('categoryDropdownMenu');
    var overlay = document.getElementById('categoryDropdownOverlay');
    var closeBtn = document.getElementById('closeDropdownBtn');
    var currentFilter = 'all';

    // Toggle burger menu
    if (burgerBtn) {
        burgerBtn.addEventListener('click', function() {
            dropdown.classList.add('active');
            overlay.classList.add('active');
            burgerBtn.classList.add('active');
        });
    }

    // Close dropdown
    function closeDropdown() {
        dropdown.classList.remove('active');
        overlay.classList.remove('active');
        if (burgerBtn) {
            burgerBtn.classList.remove('active');
        }
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeDropdown);
    }

    if (overlay) {
        overlay.addEventListener('click', closeDropdown);
    }

    // Category filter function
    window.filterByCategory = function(element, category) {
        // Determine category from element or parameter
        var selectedCategory = category || (element ? element.getAttribute('data-category') : 'all');
        currentFilter = selectedCategory;

        // Update active state for dropdown items in sidebar
        var dropdownItems = document.querySelectorAll('.dropdown-category-item');
        dropdownItems.forEach(function(item) {
            if (item.getAttribute('data-category') === selectedCategory) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Update active state for category cards in grid
        var categoryCards = document.querySelectorAll('.category-card');
        categoryCards.forEach(function(card) {
            if (card.getAttribute('data-category') === selectedCategory) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });

        // Update active state for navbar dropdown items
        var navDropdownItems = document.querySelectorAll('.nav-dropdown-item');
        navDropdownItems.forEach(function(item) {
            if (item.getAttribute('data-category') === selectedCategory) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Filter products in all product grids
        var allProducts = document.querySelectorAll('.product-card');
        var visibleCount = 0;
        
        allProducts.forEach(function(product) {
            var productCategory = product.getAttribute('data-category');
            if (selectedCategory === 'all' || productCategory === selectedCategory) {
                product.style.display = '';
                setTimeout(function() {
                    product.style.opacity = '1';
                }, 10);
                visibleCount++;
            } else {
                product.style.opacity = '0';
                setTimeout(function() {
                    product.style.display = 'none';
                }, 200);
            }
        });

        console.log('Filter applied: ' + selectedCategory + ' - ' + visibleCount + ' products shown');

        // Close dropdown after selection
        if (dropdown && dropdown.classList.contains('active')) {
            closeDropdown();
        }
        
        // Close navbar dropdown if open
        var navDropdown = document.getElementById('navCategoryDropdown');
        if (navDropdown && navDropdown.classList.contains('active')) {
            navDropdown.classList.remove('active');
            var navBtn = document.getElementById('navCategoryBtn');
            if (navBtn) {
                navBtn.classList.remove('active');
            }
        }
    };

    // Add smooth transition to products
    var style = document.createElement('style');
    style.textContent = '.product-card { transition: opacity 0.2s ease; }';
    document.head.appendChild(style);
})();
</script>
@endpush
