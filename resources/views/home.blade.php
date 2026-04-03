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
.home-cat-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    font-family: inherit;
    font-size: 13px;
    color: #555;
    background: #fafafa;
    cursor: pointer;
    min-width: 160px;
    white-space: nowrap;
    transition: border-color .2s;
    position: relative;
}
.home-cat-btn:hover, .home-cat-btn.open { border-color: #D10024; color: #D10024; }
.home-cat-btn .caret { margin-left: auto; font-size: 11px; transition: transform .2s; }
.home-cat-btn.open .caret { transform: rotate(180deg); }
.home-cat-wrap { position: relative; }
.home-cat-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    min-width: 220px;
    z-index: 9999;
    overflow: hidden;
    border: 1px solid #f0f0f0;
}
.home-cat-dropdown.open { display: block; }
.home-cat-dropdown-header {
    padding: 10px 16px;
    background: #f9f9f9;
    border-bottom: 1px solid #f0f0f0;
    font-size: 11px;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.home-cat-dropdown-items { max-height: 280px; overflow-y: auto; }
.home-cat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    cursor: pointer;
    font-size: 13px;
    color: #444;
    border-left: 3px solid transparent;
    transition: all .15s;
}
.home-cat-item:hover { background: #f9f9f9; border-left-color: #D10024; }
.home-cat-item.selected { background: rgba(209,0,36,.07); border-left-color: #D10024; color: #D10024; font-weight: 600; }
.home-cat-item-icon {
    width: 28px; height: 28px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; color: #fff; flex-shrink: 0;
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

/* ===== PRODUCT TABS ===== */
.prod-tabs-section { padding: 32px 0 24px; }
.prod-tabs-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.prod-tabs-nav { display: flex; gap: 0; border-bottom: 2px solid #f0f0f0; position: relative; }
.prod-tab-btn {
    background: none; border: none; cursor: pointer;
    font-size: 15px; font-weight: 700; color: #888;
    padding: 10px 22px 12px; position: relative;
    transition: color .2s; white-space: nowrap;
}
.prod-tab-btn.active { color: #D10024; }
.prod-tab-btn.active::after {
    content: ''; position: absolute; left: 0; right: 0; bottom: -2px;
    height: 3px; background: #D10024; border-radius: 2px 2px 0 0;
}
.prod-tab-btn:hover:not(.active) { color: #444; }
.prod-tab-pane { display: none; }
.prod-tab-pane.active { display: block; }
.prod-tabs-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
}
/* Product tile (image 3 style) */
.ptile {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1.5px solid #f0f0f0;
    transition: all .22s;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    display: block;
}
.ptile:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,0.10); border-color: rgba(209,0,36,.18); }
.ptile-img {
    position: relative;
    height: 180px;
    background: #f6f6f6;
    overflow: hidden;
}
.ptile-img img { width:100%; height:100%; object-fit:cover; transition: transform .35s; }
.ptile:hover .ptile-img img { transform: scale(1.06); }
.ptile-img-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; }
.ptile-disc-badge {
    position: absolute; top: 10px; left: 10px;
    background: #e67e22; color: #fff;
    font-size: 10px; font-weight: 800;
    padding: 3px 8px; border-radius: 4px;
    letter-spacing: .3px;
}
.ptile-body { padding: 12px 12px 14px; }
.ptile-cat { font-size: 10px; color: #D10024; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.ptile-name {
    font-size: 13px; font-weight: 700; color: #1e1f29; line-height: 1.4;
    margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.ptile-price-row { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-bottom: 8px; }
.ptile-price { font-size: 15px; font-weight: 800; color: #D10024; }
.ptile-original { font-size: 11px; color: #bbb; text-decoration: line-through; }
.ptile-pct { background: #fff0f0; color: #D10024; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; }
.ptile-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 8px; border-top: 1px solid #f5f5f5; }
.ptile-seller { font-size: 11px; color: #888; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 55%; }
.ptile-rating { font-size: 11px; color: #f39c12; display: flex; align-items: center; gap: 3px; white-space: nowrap; }
.ptile-rating span { color: #888; }
@media (max-width: 1100px) { .prod-tabs-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 768px)  { .prod-tabs-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 480px)  { .prod-tabs-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }

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
    @guest
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
    @endguest

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
            <form action="{{ route('products.index') }}" method="GET">
            @php
            $hsIconColors = ['#666','#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50'];
            $hsIcons = ['fa-th','fa-cutlery','fa-coffee','fa-shopping-bag','fa-leaf','fa-paint-brush','fa-bolt','fa-gift','fa-heart','fa-cube','fa-star'];
            @endphp
            <input type="hidden" name="category_id" id="homeCatInput" value="">
            <div class="home-search-inner">
                <div class="home-cat-wrap">
                    <button type="button" class="home-cat-btn" id="homeCatBtn">
                        <i class="fa fa-th" id="homeCatIcon" style="color:#666"></i>
                        <span id="homeCatLabel">Semua Kategori</span>
                        <i class="fa fa-chevron-down caret"></i>
                    </button>
                    <div class="home-cat-dropdown" id="homeCatDropdown">
                        <div class="home-cat-dropdown-header">Kategori Produk</div>
                        <div class="home-cat-dropdown-items">
                            <div class="home-cat-item selected" data-value="" data-label="Semua Kategori" data-icon="fa-th" data-color="#666">
                                <div class="home-cat-item-icon" style="background:#666"><i class="fa fa-th"></i></div>
                                <span>Semua Kategori</span>
                            </div>
                            @foreach($navCategories as $hIdx => $hCat)
                            <div class="home-cat-item" data-value="{{ $hCat->id }}" data-label="{{ $hCat->name }}" data-icon="{{ $hsIcons[($hIdx+1) % count($hsIcons)] }}" data-color="{{ $hsIconColors[($hIdx+1) % count($hsIconColors)] }}">
                                <div class="home-cat-item-icon" style="background:{{ $hsIconColors[($hIdx+1) % count($hsIconColors)] }}"><i class="fa {{ $hsIcons[($hIdx+1) % count($hsIcons)] }}"></i></div>
                                <span>{{ $hCat->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="text" name="search" placeholder="Cari produk UMKM favoritmu...">
                <button type="submit" class="home-search-btn">
                    <i class="fa fa-search"></i> Cari
                </button>
            </div>
            </form>
            <script>
            (function(){
                var btn = document.getElementById('homeCatBtn');
                var dd  = document.getElementById('homeCatDropdown');
                var inp = document.getElementById('homeCatInput');
                var lbl = document.getElementById('homeCatLabel');
                var ico = document.getElementById('homeCatIcon');
                btn.addEventListener('click', function(e){ e.stopPropagation(); btn.classList.toggle('open'); dd.classList.toggle('open'); });
                dd.querySelectorAll('.home-cat-item').forEach(function(item){
                    item.addEventListener('click', function(){
                        dd.querySelectorAll('.home-cat-item').forEach(function(i){ i.classList.remove('selected'); });
                        item.classList.add('selected');
                        inp.value = item.dataset.value;
                        lbl.textContent = item.dataset.label;
                        ico.className = 'fa ' + item.dataset.icon;
                        ico.style.color = item.dataset.color;
                        btn.classList.remove('open'); dd.classList.remove('open');
                    });
                });
                document.addEventListener('click', function(){ btn.classList.remove('open'); dd.classList.remove('open'); });
                dd.addEventListener('click', function(e){ e.stopPropagation(); });
            })();
            </script>
        </div>
    </div>
    @endguest

    <div class="home-content-area">

        {{-- ===== KATEGORI POPULER ===== --}}
        @php
        $catColors = ['#e74c3c','#3498db','#9b59b6','#27ae60','#e67e22','#16a085','#f39c12','#e91e8c','#1abc9c','#2c3e50'];
        $catIcons  = ['fa-cutlery','fa-coffee','fa-shopping-bag','fa-leaf','fa-paint-brush','fa-bolt','fa-gift','fa-heart','fa-cube','fa-star'];
        @endphp
        <section class="cat-populer-section">
            <style>
            .cat-populer-section { padding: 28px 0 8px; }
            .cat-populer-box {
                background: #fff;
                border-radius: 16px;
                border: 1px solid #f0f0f0;
                box-shadow: 0 2px 12px rgba(0,0,0,.06);
                display: flex;
                gap: 0;
                overflow: hidden;
                margin-bottom: 12px;
            }
            .cat-promo-card {
                background: linear-gradient(135deg, #D10024 0%, #8b0000 100%);
                min-width: 220px;
                max-width: 220px;
                padding: 28px 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: relative;
                overflow: hidden;
            }
            .cat-promo-card::before {
                content: '';
                position: absolute;
                top: -30px; right: -30px;
                width: 120px; height: 120px;
                background: rgba(255,255,255,0.08);
                border-radius: 50%;
            }
            .cat-promo-card::after {
                content: '';
                position: absolute;
                bottom: -20px; left: -20px;
                width: 90px; height: 90px;
                background: rgba(255,255,255,0.06);
                border-radius: 50%;
            }
            .cat-promo-label {
                font-size: 11px;
                font-weight: 700;
                color: rgba(255,255,255,0.7);
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 10px;
            }
            .cat-promo-title {
                font-size: 18px;
                font-weight: 800;
                color: #fff;
                line-height: 1.35;
                margin-bottom: 6px;
            }
            .cat-promo-sub {
                font-size: 12px;
                color: rgba(255,255,255,0.75);
                line-height: 1.5;
                margin-bottom: 16px;
            }
            .cat-promo-btn {
                display: inline-block;
                background: #fff;
                color: #D10024;
                font-size: 12px;
                font-weight: 700;
                padding: 8px 16px;
                border-radius: 20px;
                text-decoration: none;
                transition: all .2s;
                width: fit-content;
                position: relative;
                z-index: 1;
            }
            .cat-promo-btn:hover { background: #fff5f5; }
            .cat-populer-right {
                flex: 1;
                padding: 20px 24px;
            }
            .cat-populer-heading {
                font-size: 16px;
                font-weight: 800;
                color: #1a1b28;
                margin-bottom: 16px;
            }
            .cat-chips-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 8px;
            }
            .cat-chip {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 9px 16px 9px 10px;
                background: #f9f9f9;
                border: 1px solid #ebebeb;
                border-radius: 50px;
                text-decoration: none;
                color: #333;
                font-size: 13px;
                font-weight: 500;
                transition: all .2s;
                white-space: normal;
                word-break: break-word;
            }
            .cat-chip:hover {
                background: #fff0f2;
                border-color: #D10024;
                color: #D10024;
            }
            .cat-chip-icon {
                width: 26px; height: 26px;
                border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 12px;
                color: #fff;
                flex-shrink: 0;
            }

            @media (max-width: 768px) {
                .cat-populer-box { flex-direction: column; }
                .cat-promo-card { min-width: auto; max-width: none; flex-direction: row; align-items: center; gap: 12px; padding: 16px; }
                .cat-chips-grid { grid-template-columns: repeat(3, 1fr); }
            }
            </style>

            <div class="cat-populer-box">
                <div class="cat-promo-card">
                    <div>
                        <div class="cat-promo-label">UMKM Lokal</div>
                        <div class="cat-promo-title">Yuk, belanja di NusaMart</div>
                        <div class="cat-promo-sub">Barang lengkap dari beragam kategori</div>
                    </div>
                    <a href="{{ route('products.index') }}" class="cat-promo-btn">Cek Sekarang</a>
                </div>
                <div class="cat-populer-right">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                        <div class="cat-populer-heading" style="margin-bottom:0">Kategori Populer</div>
                        <a href="{{ route('categories.index') }}" style="font-size:13px;font-weight:600;color:#D10024;text-decoration:none;display:flex;align-items:center;gap:4px;">
                            Semua Kategori <i class="fa fa-arrow-right" style="font-size:11px"></i>
                        </a>
                    </div>
                    <div class="cat-chips-grid">
                        @foreach($navCategories->take(10) as $idx => $cat)
                        <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="cat-chip">
                            <div class="cat-chip-icon" style="background: {{ $catColors[$idx % count($catColors)] }};">
                                <i class="fa {{ $catIcons[$idx % count($catIcons)] }}"></i>
                            </div>
                            <span>{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>


        </section>

        {{-- ===== PROMO BANNER ===== --}}
        @php
            $bannerGradients = [
                'linear-gradient(135deg,#D10024,#8B0000)',
                'linear-gradient(135deg,#1565c0,#0d47a1)',
                'linear-gradient(135deg,#2e7d32,#1b5e20)',
            ];
        @endphp
        @if(!empty($promoBanners))
        <section class="promo-banner-section">
            <div class="promo-banner-grid">
                @foreach($promoBanners as $bi => $banner)
                <a href="{{ route('products.index', ['category_id' => $banner['id']]) }}"
                   class="promo-banner-card"
                   @if($bi === 0) style="min-height:200px" @endif>
                    @if($banner['image'])
                        <img src="{{ asset('storage/' . $banner['image']) }}" alt="{{ $banner['name'] }}">
                    @else
                        <div style="position:absolute;inset:0;{{ $bannerGradients[$bi % 3] }}"></div>
                    @endif
                    <div class="promo-banner-overlay">
                        <div class="promo-banner-tag"><i class="fa fa-tag"></i> {{ $banner['name'] }}</div>
                        @if($bi === 0)
                        <div class="promo-banner-title">Produk Pilihan Hari Ini</div>
                        <div class="promo-banner-sub">Temukan produk unggulan UMKM</div>
                        @else
                        <div class="promo-banner-title">{{ $banner['name'] }}</div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ===== FLASH SALE ===== --}}
        @if(!empty($flashSaleProducts))
        <section class="flash-sale-section">
            <div class="flash-sale-header">
                <div class="flash-sale-title">
                    <span class="flash-icon"><i class="fa fa-bolt"></i></span>
                    Flash Sale
                </div>
                <div class="flash-countdown">
                    <span style="color:#888;font-size:12px;margin-right:4px;">Berakhir dalam:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-h">00</span>
                        <span class="countdown-label">jam</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-m">00</span>
                        <span class="countdown-label">mnt</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-block">
                        <span class="countdown-num" id="cd-s">00</span>
                        <span class="countdown-label">dtk</span>
                    </div>
                </div>
            </div>
            <div class="flash-sale-scroll">
                <div class="flash-products-row">
                    @foreach($flashSaleProducts as $p)
                    <a href="{{ route('products.show', $p['id']) }}" class="flash-product-card" style="text-decoration:none;color:inherit">
                        @if($p['image'])
                        <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}">
                        @else
                        <div style="width:100%;height:140px;background:#2a2b3a;display:flex;align-items:center;justify-content:center">
                            <i class="fa fa-image" style="font-size:40px;color:#444"></i>
                        </div>
                        @endif
                        <div class="flash-product-info">
                            <div class="flash-product-name">{{ $p['name'] }}</div>
                            <div class="flash-price-row">
                                <span class="flash-price">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                                <span class="flash-original">Rp {{ number_format($p['original_price'], 0, ',', '.') }}</span>
                                <span class="flash-disc">{{ round((1 - $p['price'] / $p['original_price']) * 100) }}%</span>
                            </div>
                            <div class="flash-progress">
                                <div class="flash-progress-bar">
                                    <div class="flash-progress-fill" style="width: {{ min(100, ($p['sold'] / 300) * 100) }}%"></div>
                                </div>
                                <div class="flash-progress-text">Terjual {{ $p['sold'] }}</div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- ===== TABBED PRODUCTS ===== --}}
        <section class="prod-tabs-section">
            <div class="container">
                @php
                    $tabUsername = Auth::check() ? explode(' ', Auth::user()->name)[0] : 'Kamu';
                @endphp
                <div class="prod-tabs-nav" id="prodTabsNav">
                    <button class="prod-tab-btn active" onclick="switchProdTab('for_user', this)">
                        For {{ $tabUsername }}
                    </button>
                    <button class="prod-tab-btn" onclick="switchProdTab('rekomendasi', this)">
                        Rekomendasi
                    </button>
                    <button class="prod-tab-btn" onclick="switchProdTab('populer', this)">
                        Populer
                    </button>
                </div>

                @foreach(['for_user' => $tabProducts['for_user'], 'rekomendasi' => $tabProducts['rekomendasi'], 'populer' => $tabProducts['populer']] as $tabKey => $tabItems)
                <div class="prod-tab-pane {{ $tabKey === 'for_user' ? 'active' : '' }}" id="prod-tab-{{ $tabKey }}" style="padding-top:20px">
                    @if(count($tabItems) > 0)
                    <div class="prod-tabs-grid">
                        @foreach($tabItems as $p)
                        @php $disc = round((1 - $p['price'] / $p['original_price']) * 100); @endphp
                        <a href="{{ route('products.show', $p['id']) }}" class="ptile">
                            <div class="ptile-img">
                                @if($p['image'])
                                    <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}">
                                @else
                                    <div class="ptile-img-placeholder">
                                        <i class="fa fa-image" style="font-size:36px;color:#ddd"></i>
                                    </div>
                                @endif
                                @if($disc > 0)
                                <span class="ptile-disc-badge">{{ $disc }}%</span>
                                @endif
                            </div>
                            <div class="ptile-body">
                                <div class="ptile-cat">{{ $p['category'] }}</div>
                                <div class="ptile-name">{{ $p['name'] }}</div>
                                <div class="ptile-price-row">
                                    <span class="ptile-price">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                                    @if($disc > 0)
                                    <span class="ptile-original">Rp {{ number_format($p['original_price'], 0, ',', '.') }}</span>
                                    <span class="ptile-pct">{{ $disc }}%</span>
                                    @endif
                                </div>
                                <div class="ptile-footer">
                                    <span class="ptile-seller"><i class="fa fa-store"></i> {{ $p['seller'] }}</span>
                                    <span class="ptile-rating">
                                        <i class="fa fa-star"></i>
                                        {{ $p['rating'] }}
                                        <span>({{ $p['sold'] }})</span>
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div style="text-align:center;padding:48px;color:#bbb">
                        <i class="fa fa-box-open" style="font-size:40px;display:block;margin-bottom:12px"></i>
                        <div>Belum ada produk tersedia</div>
                    </div>
                    @endif
                </div>
                @endforeach

                <div style="text-align:center;margin-top:24px">
                    <a href="{{ route('products.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 28px;border:1.5px solid #D10024;color:#D10024;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s"
                       onmouseover="this.style.background='#D10024';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='#D10024'">
                        Lihat Semua Produk <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
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


</div>{{-- /home-wrapper --}}
@endsection

@push('scripts')
<script>
// Product Tab Switcher
function switchProdTab(key, btn) {
    document.querySelectorAll('.prod-tab-pane').forEach(function(p){ p.classList.remove('active'); });
    document.querySelectorAll('.prod-tab-btn').forEach(function(b){ b.classList.remove('active'); });
    document.getElementById('prod-tab-' + key).classList.add('active');
    btn.classList.add('active');
}

// Countdown Timer
(function() {
    // Countdown to midnight (flash sale resets daily with new products)
    var now = new Date();
    var deadline = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0);

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
