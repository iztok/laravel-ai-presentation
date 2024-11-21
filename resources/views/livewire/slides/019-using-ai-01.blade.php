<x:slide>
### How can we use AI? CURL example from OpenAI docs.
```
curl "https://api.openai.com/v1/chat/completions" \
    -H "Content-Type: application/json" \
    -H "Authorization: Bearer $OPENAI_API_KEY" \
    -d '{
        "model": "gpt-4o",
        "messages": [
            {
                "role": "user",
                "content": "Write a haiku about Laravel."
            }
        ]
    }'
```
</x:slide>