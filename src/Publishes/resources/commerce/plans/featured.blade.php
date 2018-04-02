<div class="row">
    @foreach ($plans as $plan)
        @if ($plan->is_featured)
            <div class="col-md-3">
                <div class="card card-default mb-4">
                    <div class="card-header text-center">
                        <span class="plan-title"><a href="{{ $plan->href }}">{{ $plan->name }}</a></span>
                    </div>
                    <div class="card-body text-center plan-details">
                        <span class="lead">$ {{ $plan->amount }} {{ strtoupper($plan->currency) }}/ {{ strtoupper($plan->interval) }}</span><br>
                        <span class="plan-slogan">{{ $plan->slogan }}</span><br>
                        <span class="plan-description">{{ $plan->description }}</span>
                    </div>
                    <div class="card-footer">
                        <a href="{{ $plan->href }}">Subscribe</a>
                    </div>
                </div>
            </div>

        @endif
    @endforeach
</div>