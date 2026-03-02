@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="From Elements" />
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="space-y-6">
            <x-form.form-elements.default-inputs />
            <x-form.form-elements.select-inputs />
            <!-- Missing text-area-inputs removed -->
            <x-form.form-elements.input-states />
        </div>
        <div class="space-y-6">
            <x-form.form-elements.input-group />
            <!-- Missing file-input-example removed -->
            <!-- Missing checkbox-component removed -->
            <x-form.form-elements.radio-buttons />
            <!-- Missing toggle-switch removed -->
            <!-- Missing dropzone removed -->
        </div>
    </div>
@endsection