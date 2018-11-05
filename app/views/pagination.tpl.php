<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
  <?php if( $currentPage > 1 ) : ?>
    <li class="page-item"><a class="page-link" href="/page/1">First Page</a></li>
    <li class="page-item"><a class="page-link" href="/page/<?=$currentPage-1?>">Previous</a></li>
  <?php else : ?>  
    <li class="page-item disabled"><span class="page-link">First</span></li>
    <li class="page-item disabled"><span class="page-link">Previous</span></li>
  <?php endif; ?>
  <?php for ( $pageNum=$currentPage-$activeLink; $pageNum<=$pageLast; $pageNum++ ) : ?>
  <?php if ( $pageNum>0 ) : ?>
  <?php if ( $pageNum <= $currentPage + $activeLink && $pageNum >= $currentPage - $activeLink) : ?>
  <?php if( $pageNum==$currentPage ) : ?>
    <li class="page-item active"><a class="page-link current"><?=$pageNum?></a></li>
  <?php elseif ( $pageNum == $currentPage + $activeLink ) : ?>
    <li class="page-item"><a class="page-link" href="/page/<?=$pageNum?>">...</a></li>
  <?php elseif ( $pageNum == $currentPage - $activeLink) : ?>
    <li class="page-item"><a class="page-link" href="/page/<?=$pageNum?>">...</a></li>
  <?php else : ?>
    <li class="page-item"><a class="page-link" href="/page/<?=$pageNum?>"><?=$pageNum?></a></li>
  <?php endif; ?>
  <?php endif; ?>
  <?php endif; ?>
  <?php endfor; ?>
  <?php if( $currentPage != $pageLast) : ?>
    <li class="page-item"><a class="page-link" href="/page/<?=$currentPage+1?>">Next</a></li>
    <li class="page-item"><a class="page-link" href="/page/<?=$pageLast?>">Last Page</a></li>
  <?php else : ?>
    <li class="page-item disabled"><span class="page-link">Next</span></li>
    <li class="page-item disabled"><span class="page-link">Last Page</span></li>
  <?php endif; ?>
  </ul>
</nav>
