<?php
// Base URL configuration
$base_url = '/';

// Function to generate URLs relative to the base URL
function url($path = '') {
    global $base_url;
    return $base_url . ltrim($path, '/');
}

// Function to generate asset URLs
function asset($path) {
    return url('assets/' . ltrim($path, '/'));
}

// Function to generate upload URLs
function upload($path) {
    return url('uploads/' . ltrim($path, '/'));
} 