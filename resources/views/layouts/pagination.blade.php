@if (isset($paginator) && $paginator->lastPage() > 1)
   
<ul class="uk-pagination uk-flex-center uk-margin-medium-top" uk-margin>
    
    <?php
    $interval = isset($interval) ? abs(intval($interval)) : 3 ;
    $from = $paginator->currentPage() - $interval;
    if($from < 1){
        $from = 1;
    }
    
    $to = $paginator->currentPage() + $interval;
    if($to > $paginator->lastPage()){
        $to = $paginator->lastPage();
    }
    ?>
    
    <!-- first/previous -->
    @if($paginator->currentPage() > 1)
        <!--<li class="">
            <a href="{{ $paginator->url(1) }}" aria-label="First">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>-->

        <li class="">
            <a href="{{ $paginator->url($paginator->currentPage() - 1) }}" aria-label="Previous">
                <span uk-pagination-previous></span>
            </a>
        </li>
    @endif
    
    <!-- links -->
    @for($i = $from; $i <= $to; $i++)
        <?php 
        $isCurrentPage = $paginator->currentPage() == $i;
        ?>
        <li class=" {{ $isCurrentPage ? 'uk-active' : '' }}">
            <a  href="{{ !$isCurrentPage ? $paginator->url($i) : '#' }}">
                {{ $i }}
            </a>
        </li>
    @endfor
    
    <!-- next/last -->
    @if($paginator->currentPage() < $paginator->lastPage())
        <li class="">
            <a href="{{ $paginator->url($paginator->currentPage() + 1) }}" aria-label="Next">
                <span uk-pagination-next></span>
            </a>
        </li>

        <!--<li class="">
            <a href="{{ $paginator->url($paginator->lastpage()) }}" aria-label="Last">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>-->
    @endif
    
</ul>

@endif