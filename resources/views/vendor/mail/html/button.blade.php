@props(['url'])
<table class="action"
       align="left"
       width="100%"
       cellpadding="0"
       cellspacing="0"
       role="presentation">
    <tr>
        <td align="left">
            <table width="100%"
                   border="0"
                   cellpadding="0"
                   cellspacing="0"
                   role="presentation">
                <tr>
                    <td align="left">
                        <table border="0"
                               cellpadding="0"
                               cellspacing="0"
                               role="presentation">
                            <tr>
                                <td>
                                    <a href="{{ $url }}"
                                       title="{{ $slot }}"
                                       class="button button-success"
                                       target="_blank"
                                       rel="noopener">{{ $slot }}</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
