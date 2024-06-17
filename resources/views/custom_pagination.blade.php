<style>
.pagination {
  display: flex;
  justify-content: flex-start; /* Align navigation to the left */
  list-style: none;
  padding: 0;
  margin: 20px 0; /* Adjust margin as needed */
}

.pagination li {
  margin: 0 5px;
}

.pagination li a,
.pagination li span {
  display: inline-block;
  padding: 5px 10px;
  border: 1px solid #ddd; /* Light gray border */
  border-radius: 3px;
  color: #333; /* Darker text for better contrast */
  text-decoration: none;
}

.pagination li.disabled span,
.pagination li.disabled a {
  color: #aaa;
  pointer-events: none;
  cursor: default;
}

.pagination li.active a {
  background-color: #fff; /* White background for active page */
  color: #007bff; /* Blue text for active page */
  border-color: #fff; /* Remove border for active page */
}

.pagination li a:hover {
  background-color: #f2f2f2; /* Light gray hover effect */
}

/* Optional: Additional styling for a white overall look */
body {
  background-color: #fff; /* White background for the entire page */
}

.container { /* Assuming you have a container element */
  background-color: #fff; /* White background for the container */
  padding: 20px; /* Add some padding for better separation */
}
</style>




@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        <!-- Tautan ke halaman sebelumnya -->
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        <!-- Loop untuk tautan ke setiap halaman -->
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li>
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <!-- Tautan ke halaman berikutnya -->
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
