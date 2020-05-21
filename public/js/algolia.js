const client = algoliasearch("RHC6DFKJ3V", "077a01059053b34f8e788089f4f1f3f2");
const index1 = client.initIndex('posts');
const index2 = client.initIndex('giftcon_trade_posts');

autocomplete('#aa-search-input', {}, [
    {
      source: autocomplete.sources.hits(index1, { hitsPerPage: 3 }),
      displayKey: 'name',
      templates: {
        header: '<div class="aa-suggestions-category">게시글</div>',
        suggestion({_highlightResult}) {
          return `<span>${_highlightResult.title.value}</span><span>${_highlightResult.body.value}</span>`;
        },
        empty:function(result){
            return result.query+" 에 대한 검색결과가 없습니다."
        },
      }
    },
    {
      source: autocomplete.sources.hits(index2, { hitsPerPage: 3 }),
      displayKey: 'name',
      templates: {
        header: '<div class="aa-suggestions-category">거래글</div>',
        suggestion({_highlightResult}) {
          return `<span>${_highlightResult.name.value}</span><span>${_highlightResult.location.value}</span>`;
        }
      }
    }
]);