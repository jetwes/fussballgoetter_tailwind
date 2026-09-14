@if (session('success-message') || session('error-message') || session('status'))
    <div class="mb-6 space-y-3">
        @if (session('success-message') || session('status'))
            <flux:callout variant="success" icon="check-circle" :heading="session('success-message') ?? session('status')" />
        @endif
        @if (session('error-message'))
            <flux:callout variant="warning" icon="exclamation-triangle" :heading="session('error-message')" />
        @endif
    </div>
@endif
