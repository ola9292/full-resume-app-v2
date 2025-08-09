<script setup>
</script>

<!-- SubscriptionStatus.vue -->
<template>
    <div v-if="activePayment" class="subscription-status">
        <div class="alert" :class="alertClass">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>
                        <i class="fas fa-crown me-2"></i>
                        Premium Access Active
                    </strong>
                    <div class="small">
                        {{ remainingText }}
                    </div>
                </div>
                <div class="text-end">
                    <div class="small text-muted">Expires</div>
                    <div class="fw-bold">{{ formatDate(activePayment.expires_at) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="subscription-status">
        <div class="alert alert-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>
                        <i class="fas fa-lock me-2"></i>
                        Premium Access Required
                    </strong>
                    <div class="small">
                        Subscribe to create, download, and view unlimited resumes
                    </div>
                </div>
                <a href="/stripe" class="btn btn-success btn-sm">
                    <i class="fas fa-credit-card me-1"></i>
                    Subscribe Now
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SubscriptionStatus',
    props: {
        activePayment: {
            type: Object,
            default: null
        }
    },

    computed: {
        daysRemaining() {
            if (!this.activePayment) return 0;

            const now = new Date();
            const expires = new Date(this.activePayment.expires_at);
            const diffTime = expires - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            return Math.max(0, diffDays);
        },

        remainingText() {
            const days = this.daysRemaining;
            if (days === 0) {
                return 'Expires today';
            } else if (days === 1) {
                return '1 day remaining';
            } else {
                return `${days} days remaining`;
            }
        },

        alertClass() {
            const days = this.daysRemaining;
            if (days <= 1) {
                return 'alert-danger';
            } else if (days <= 3) {
                return 'alert-warning';
            } else {
                return 'alert-success';
            }
        }
    },

    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        }
    }
}
</script>

<style scoped>
.subscription-status {
    margin-bottom: 1rem;
}

.alert {
    border-radius: 8px;
    border: none;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left: 4px solid #28a745;
}

.alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left: 4px solid #ffc107;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border-left: 4px solid #dc3545;
}

.fas.fa-crown {
    color: #ffd700;
}

.fas.fa-lock {
    color: #6c757d;
}
</style>