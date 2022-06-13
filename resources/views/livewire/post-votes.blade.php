<div class="text-center">
    <div>
        <a wire:click.prevent="vote(1)" href="#">
            <i class="fa fa-2x fa-sort-asc" aria-hidden="true"></i>
        </a>
    </div>
    <div class="font-bold text-2xl">{{ $sumVotes }}</div>
    <div>
        <a wire:click.prevent="vote(-1)" href="#">
            <i class="fa fa-2x fa-sort-desc" aria-hidden="true"></i>
        </a>
    </div>
</div>
