<x:slide>
## Tools and function calling

- Function calling allows you to connect models to external tools and systems
- Available for OpenAI, Anthropic and Ollama (some models)
- The AI generates parameters for function calls but doesn't execute them.

![Function Flow](https://github.com/theodo-group/LLPhant/raw/main/doc/assets/function-flow.png)


This helper will automatically gather information to describe the tools
```php
$tool = FunctionBuilder::buildFunctionInfo(
    new MailerExample(),
    'sendMail'
);
```
Add the tool to the chat object
```php
$chat->addTool($tool);
```
</x:slide>
